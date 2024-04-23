<?php

namespace App\Http\Controllers\Student;

use App\Helpers\CurrentPromotion;
use App\Helpers\PastPromotion;
use App\Http\Controllers\Controller;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mclass;
use App\Models\ClassMatiere;
use App\Http\Requests\UserRequest;
use App\Models\Avatar;
use App\Models\Evaluate;
use App\Models\Matiere;
use App\Models\Promotion;
use App\Models\Semestre;
use App\Models\StudentClasse;
use App\Models\Ue;
use Illuminate\Support\Facades\Auth;
use Image;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    public function myBulletinsCanonic($promotion, $semestre)
    {

        $getUser = Auth::user();

        return $this->createBulletins($promotion, $semestre, $getUser, 'canonic');
    }

    function myBulletins($promotion, $semestre)
    {
        // je dois afficher la liste des matiere de la classe de l'étudiant $user,
        // avec pour chaque matiere son Ue, Son semestre, les notes obtenues 
        // pour la promotion $promotion

        $getUser = Auth::user();

        return $this->createBulletins($promotion, $semestre, $getUser);
    }

    function createBulletins($promotion, $semestre, $getUser, $canonique = null)
    {
        try {

            $getPromotion = Promotion::where('name', $promotion)->first();

            // Récupérer la classe de l'étudiant pour la promotion actuelle
            $userClasse = StudentClasse::where('user_id', $getUser->id)
                ->where('promotion_id', $getPromotion->id)
                ->firstOrFail();

            $matieres = ClassMatiere::select('matiere_mclass.*', 'm.name AS matiere_name', 'e.controle', 'e.examen')
                ->join('matieres as m', 'matiere_mclass.matiere_id', '=', 'm.id')
                ->leftJoin('evaluates as e', function ($join) use ($getUser, $getPromotion) {
                    $join->on('matiere_mclass.matiere_id', '=', 'e.matiere_id')
                        ->where('e.user_id', $getUser->id)
                        ->where('e.promotion_id', $getPromotion->id);
                })
                ->where('matiere_mclass.promotion_id', $getPromotion->id)
                ->where('matiere_mclass.mclass_id', $userClasse->mclass->id)
                ->whereExists(function ($query) use ($semestre) {
                    $query->select(DB::raw(1))
                        ->from('matiere_semestre as ms')
                        ->join('semestres', 'ms.semestre_id', '=', 'semestres.id')
                        ->whereColumn('ms.matiere_id', 'matiere_mclass.matiere_id')
                        ->where('semestres.id', $semestre); // Utilisation de la variable $semestre
                })
                ->get();
            $semestreObjet = Semestre::findOrfail($semestre);
            $typesUE = UE::pluck('type')->toArray();


            if ($canonique && ($semestre == "Semestre 1 (LC)" || $semestre == "Semestre 2 (LC)" || $semestre == "Semestre 3 (LC)")) {

                if (in_array($semestre, ['Semestre 1 (LC)', 'Semestre 3 (LC)'])) {

                    $pdf = PDF::loadView('student.promotion.canonique.bulletin-semestre1',  compact('getUser', 'semestre', 'semestreObjet', 'getPromotion', 'userClasse', 'matieres', 'typesUE'));

                    // Lancement du téléchargement du fichier PDF
                    return $pdf->download('Bulletin--' . $semestreObjet->name . '--Année(' . $getPromotion->name . ').pdf');

                    // return view('student.promotion.canonique.bulletin-semestre1', compact( 'getUser', 'semestre', 'getPromotion', 'userClasse', 'matieres'));
                }

                $pdf = PDF::loadView('student.promotion.canonique.bulletin-semestre2',  compact('getUser', 'semestre', 'semestreObjet', 'getPromotion', 'userClasse', 'matieres', 'typesUE'));

                return $pdf->download('Bulletin--' . $semestreObjet->name . '--Année(' . $getPromotion->name . ').pdf');
            }

            if (in_array($semestre, ['Semestre 1', 'Semestre 1 (MA)', 'Semestre 3', 'Semestre 5'])) {

                $pdf = PDF::loadView('student.promotion.bulletin-semestre1',  compact('getUser', 'semestre', 'semestreObjet', 'getPromotion', 'userClasse', 'matieres', 'typesUE'));

                // Lancement du téléchargement du fichier PDF
                return $pdf->download('Bulletin--' . $semestreObjet->name . '--Année(' . $getPromotion->name . ').pdf');

                // return view('student.promotion.bulletin-semestre1', compact( 'getUser', 'semestre', 'getPromotion', 'userClasse', 'matieres'));
            }

            $pdf = PDF::loadView('student.promotion.bulletin-semestre2',  compact('getUser', 'semestre', 'semestreObjet', 'getPromotion', 'userClasse', 'matieres', 'typesUE'));

            return $pdf->download('Bulletin--' . $semestreObjet->name . '--Année(' . $getPromotion->name . ').pdf');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la création du bulletin: ' . $e->getMessage());
            // Gérer l'erreur ici, rediriger ou afficher un message d'erreur
        }
    }
    function showMyBulletins($promotion, $semestre, $id = null, $canonique = null)
    {
        try {
            $user = $id ? User::where('id', $id)->first() : auth()->user();

            $getUser = Auth::user();

            // Récupérer l'objet Promotion actuelle
            $getPromotion = Promotion::where('name', $promotion)->first();

            // Récupérer la classe de l'étudiant pour la promotion actuelle
            $userClasse = StudentClasse::where('user_id', $getUser->id)
                ->where('promotion_id', $getPromotion->id)
                ->firstOrFail();
            Log::info('User class retrieved: ' . $userClasse);

            $matieres = ClassMatiere::select('matiere_mclass.*', 'm.name AS matiere_name', 'e.controle', 'e.examen')
                ->join('matieres as m', 'matiere_mclass.matiere_id', '=', 'm.id')
                ->leftJoin('evaluates as e', function ($join) use ($getPromotion, $getUser) {
                    $join->on('matiere_mclass.matiere_id', '=', 'e.matiere_id')
                        ->where('e.user_id', $getUser->id)
                        ->where('e.promotion_id', $getPromotion->id);
                })
                ->where('matiere_mclass.promotion_id', $getPromotion->id)
                ->where('matiere_mclass.mclass_id', $userClasse->mclass->id)
                ->whereExists(function ($query) use ($semestre) {
                    $query->select(DB::raw(1))
                        ->from('matiere_semestre as ms')
                        ->join('semestres', 'ms.semestre_id', '=', 'semestres.id')
                        ->whereColumn('ms.matiere_id', 'matiere_mclass.matiere_id')
                        ->where('semestres.id', $semestre);
                })
                ->get();

            $semestreObjet = Semestre::findOrFail($semestre);

            //  Je Supprime les espaces supplémentaires du nom du semestre
            $semestreName = trim($semestreObjet->name);


            $viewPath = 'student.promotion.bulletin-semestre2'; // Par défaut, le cas non spécifié

            // Vérification du chemin de la vue
            if ($viewPath !== '') {
                return view($viewPath, compact('getUser', 'semestre', 'getPromotion', 'semestreObjet', 'userClasse', 'matieres'));
            }
        } catch (\Exception $e) {
            Log::error('Error displaying bulletin: ' . $e->getMessage());
            // Gérer l'erreur ici, rediriger ou afficher un message d'erreur
        }
    }



    function studentBulletin($promotion, $user, $semestre)
    {
        // je dois afficher la liste des matiere de la classe de l'étudiant $user,
        // avec pour chaque matiere son Ue, Son semestre, les notes obtenues 
        // pour la promotion $promotion

        $getUser = User::find($user);

        return $this->createBulletins($promotion, $semestre, $getUser);

        //return view('student.promotion.bulletin-semestre2', compact( 'getUser', 'semestre', 'getPromotion', 'userClasse', 'matieres'));
    }

    function studentBulletinCanonique($promotion, $user, $semestre)
    {
        // je dois afficher la liste des matiere de la classe de l'étudiant $user,
        // avec pour chaque matiere son Ue, Son semestre, les notes obtenues 
        // pour la promotion $promotion

        $getUser = User::find($user);

        return $this->createBulletins($promotion, $semestre, $getUser, 'canonic');

        //return view('student.promotion.bulletin-semestre2', compact( 'getUser', 'semestre', 'getPromotion', 'userClasse', 'matieres'));
    }
    public function bulletin($id = null)
    {
        $user = $id ? User::where('id', $id)->first() : auth()->user();

        $userClasseWithPromotion = $user->studentPromotionClasses()
            ->with(['promotion', 'mclass'])
            ->get();

        $semestresByPromotion = []; // tableau pour stocker les semestres par promotion

        foreach ($userClasseWithPromotion as $promotion) {
            $semestres = DB::table('student_classes')
                ->join('users as u', 'student_classes.user_id', '=', 'u.id')
                ->join('mclasses as mc', 'student_classes.mclass_id', '=', 'mc.id')
                ->join('levels as l', 'mc.level_id', '=', 'l.id')
                ->leftJoin('semestres as s', 's.level_id', '=', 'l.id')
                ->where('l.name', $promotion->mclass->level->name)
                ->where('u.id', $user->id)
                ->groupBy('u.id', 'u.name', 'u.firstname', 'u.phone', 'u.address', 'u.type', 'u.email', 's.name', 's.id')
                ->select('u.id', 'u.name', 'u.firstname', 'u.phone', 'u.address', 'u.type', 'u.email', 's.name as semestre_name', 's.id as semestre_id')
                ->get();

            $semestresByPromotion[$promotion->promotion->name] = $semestres;
        }


        $currentPromotionId = CurrentPromotion::currentPromotion();

        return view('student.bullettin', compact('userClasseWithPromotion', 'id', 'currentPromotionId', 'user', 'semestresByPromotion'));
    }

    public function save(UserRequest $request)
    {
        /**
         * name
         * email
         * phone
         *  type
         * address
         */

        $request['is_active'] = false;
        $userData = $request->only([
            'name',
            "firstname",
            'address',
            'email',
            'phone',
            "gender",
            'password',
            'type',
            "matricule",
            "is_active"
        ]);
        $user = User::create($userData);

        StudentClasse::create(['user_id' => $user->id, "promotion_id" => CurrentPromotion::currentPromotion()['id'], "mclass_id" => $request->mclasse_id]);

        return redirect()->back()->with('success', 'Inscription effectué avec succes');
    }
    public function inscrire()
    {
        $classes = Mclass::All();

        return view('student.inscrire', compact('classes'));
    }

    public function matieres()
    {
        //ici je veux afficher la liste de matiere de la classe actuelle de l'étudiant

        $currentPromotionId = CurrentPromotion::currentPromotion()['id'];
        $user = auth()->user();
        $userClasse = StudentClasse::where('user_id', $user->id)
            ->where('promotion_id', $currentPromotionId)
            ->first();

        $courses = ClassMatiere::where('promotion_id', $currentPromotionId)
            ->where('mclass_id', $userClasse->mclass_id)
            ->with('teachers')
            ->with('matiere', function ($mat) use ($user) {
                $mat->with('evaluation', function ($eval) use ($user) {
                    $eval->where('user_id', $user->id);
                });
            })
            ->get();

        //get user current promotion class
        $userLevel = $user->studentPromotionClasses()->where('promotion_id', $currentPromotionId)->first();

        //dd($userClasse);
        return view('student.course', compact('courses', 'userLevel'));
    }
    public function index()
    {
        $students = User::where('type', 'student')
            ->with(['studentPromotionClasses' => function ($classePromotion) {
                $classePromotion->where('promotion_id', CurrentPromotion::currentPromotion()['id'])
                    ->with('mclass');
            }])
            ->get();
        $user = User::find(auth()->user()->id);
        $roles = $user->roles()->select('slug')->get();
        return view('student.index', compact('students', 'roles'));
    }


    public function dashboard($id = null)
    {
        $user = auth()->user();
        if ($id) {
            $user = User::find($id);
        }

        $userClasse = StudentClasse::where('user_id', $user->id)
            ->where('promotion_id', CurrentPromotion::currentPromotion()['id'])
            ->first();

        if (!$userClasse) {
            Auth::logout();
            return redirect('login')->with('error', 'Veuillez contacter l\'administration svp');
        }

        $userLevel = $user->studentPromotionClasses()
            ->where('promotion_id', CurrentPromotion::currentPromotion()['id'])
            ->first();

        $courses = ClassMatiere::where('mclass_id', $userClasse->mclass_id)
            ->with(['matiere.evaluation' => function ($query) use ($user) {
                $query->where('promotion_id', CurrentPromotion::currentPromotion()['id'])
                    ->where('user_id', $user->id);
            }])
            ->get();

        foreach ($courses as $course) {
            $semestre = Semestre::where('id', $course->matiere->semestre)->first();
        }

        $viewName = 'student.dashboard';
        switch ($userLevel->mclass->level->name) {
            case "Licence 1":
                $viewName = 'student.level.licence1';
                break;
            case "Licence 2":
                $viewName = 'student.level.licence2';
                break;
            case "Licence 3":
                $viewName = 'student.level.licence3';
                break;
            case "Master 1":
                $viewName = 'student.level.masteur1';
                break;
            case "Master 2":
                $viewName = 'student.level.masteur2';
                break;
        }

        return view($viewName, compact('courses', 'course', 'userLevel', 'semestre'));
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $classes = Mclass::All();

        return view('student.create', compact('classes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


     public function jour_soir(Request $request)
     {
         try {
             Log::info('Début de la fonction jour_soir');
     
             $user = User::where('id', $request->user_id)->first();
     
             Log::info('Utilisateur trouvé : ' . $user->id);
     
             // Basculer la valeur de night entre 0 et 1
             $newNightValue = ($user->night == 0) ? 1 : 0;
     
             Log::info('Nouvelle valeur de night : ' . $newNightValue);
     
             $user->update([
                 'night' => $newNightValue
             ]);
     
             Log::info('Mise à jour de l\'utilisateur : ' . $user->id . ' - Valeur night : ' . $user->night);
     
             return response()->json([
                 'success' => 'Effectué avec succès',
                 'night' => $user->night
             ], 200);
         } catch (\Exception $e) {
             Log::error('Une erreur est survenue dans la fonction jour_soir : ' . $e->getMessage());
     
             return response()->json([
                 'error' => 'Une erreur est survenue : ' . $e->getMessage()
             ], 500);
         }
     }
     
    public function Mat_jour_soir(request $request)
    {
        $matiere = matiere::where('mclass_id',  $request->input('matiere_id'));

        $matiere->update([
            'night' => 1
        ]);
        return response()->json([
            'success' => 'effectué avec succes',
            'night' => $matiere['night']
        ], 200);
    }
    public function store(UserRequest $request)
    {
        /**
         * name
         * email
         * phone
         *  type
         * address
         */

        // je crée un mot de passe par défaut pour tous les étudiants 
        $request['password'] = "Etudi@nt";
        $userData = $request->only([
            'name',
            "firstname",
            'address',
            'email',
            'phone',
            'birth_day',
            'birth_place',
            'nationality',
            "gender",
            'password',
            'type',
            "matricule",
        ]);
        $user = User::create($userData);

        StudentClasse::create(['user_id' => $user->id, "promotion_id" => CurrentPromotion::currentPromotion()['id'], "mclass_id" => $request->mclasse_id]);

        return redirect()->route('students.create')->with('success', 'Enregistrement d\'etudiant effectué avec succes');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $studentClasse = StudentClasse::find($id);
        $class = null; // Initialisation de $class à null

        if ($studentClasse) {
            $class = $studentClasse->mclass;
        }

        $student = User::find($id);
        $classes = Mclass::all();

        return view('student.edit', compact('student', 'classes', 'class'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $student = User::find($id);
        $student->update($request->all());
        StudentClasse::updateOrCreate(
            ['user_id' => $student->id], // Critères de recherche pour trouver l'entrée existante
            [
                "promotion_id" => CurrentPromotion::currentPromotion()['id'],
                "mclass_id" => $request->mclass_id
            ] // Valeurs à mettre à jour ou à créer
        );

        return redirect()->back()->with('success', 'Modification effectué avec succès');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function programme()
    {
        $classe = Mclass::find(auth()->user()->mclasse_id);
        if (!$classe) {
            return redirect()->route('student.dasboard');
        } else {
            $programme = 'uploads/' . $classe->time_usage;
        }


        return view('classe.programme', compact('programme'));
        # code...
    }

    public function addAvatar($id)
    {
        $student = User::findOrFail($id);

        return view('student.addProfile', compact('student'));
    }

    public function addProfi(Request $request)
    {

        $this->validate($request, [
            'file' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $image = Image::make($request->file('file'));

        $imageName = time() . '-' . $request->file('file')->getClientOriginalName();
        $destinationPath = public_path('images/');
        $image->save($destinationPath . $imageName);

        /**
         * Generate Thumbnail Image Upload on Folder Code
         */
        $destinationPathThumbnail = public_path('images/thumbnail/');
        $image->resize(200, 200);
        $image->save($destinationPathThumbnail . $imageName);

        $request['url'] = $imageName;
        $request['user_id'] = auth()->user()->id;

        if (auth()->user()->avatar) {
            auth()->user()->avatar->update(['url' => $imageName]);
        } else {

            Avatar::create($request->input());
        }

        return view('student.addProfile')->with('success', 'Image Upload successful')
            ->with('imageName', $imageName);
    }

    public function addProfil(Request $request, $userId)
    {
        $this->validate($request, [
            'file' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $image = Image::make($request->file('file'));

        $imageName = time() . '-' . $request->file('file')->getClientOriginalName();
        $destinationPath = public_path('images/');
        $image->save($destinationPath . $imageName);

        /**
         * Generate Thumbnail Image Upload on Folder Code
         */
        $destinationPathThumbnail = public_path('images/thumbnail/');
        $image->resize(200, 200);
        $image->save($destinationPathThumbnail . $imageName);

        // Récupérer l'utilisateur en utilisant son ID
        $user = User::findOrFail($userId);

        // Assurez-vous de créer ou de mettre à jour l'avatar de cet utilisateur
        if ($user->avatar) {
            $user->avatar->update(['url' => $imageName]);
        } else {
            $user->avatar()->create(['url' => $imageName]);
        }

        return view('student.imageok')->with('success', 'Image Upload successful')
            ->with('imageName', $imageName);
    }


    public function profilImage()
    {
        $image = Avatar::where("user_id", auth()->user()->id)->first();
        return view('student.profile', compact('image'));
    }

    public function studentCart($id)
    {
        $sector = null;
        $student = StudentClasse::find($id);
        if ($student) {
            $sector = $student->mclass->sector;
        }

        $image = Avatar::where("user_id", $student->id)->first();
        if ($student) {

            $front_url = env('SITE_URL');

            //$qrcode = QrCode::size(100)->generate($front_url . '/student/' . $student->id . '/carte');

            return view('student.carte', compact('student', 'image', 'sector'));
        }
    }

    public function studentCarte($id)
    {
        Log::info('Début de la fonction studentCarte');

        $sector = null;
        $student = StudentClasse::where('user_id', $id)->first();

        if ($student) {
            Log::info('Étudiant trouvé. ID : ' . $student->id);
            $sector = $student->mclass->sector;
        } else {
            Log::warning('Étudiant non trouvé pour l\'ID : ' . $id);
        }

        if ($student) {
            Log::info('Récupération de l\'image pour l\'étudiant ID : ' . $student->id);
            $image = Avatar::where("user_id", $student->student->id)->first();

            $front_url = env('SITE_URL');
            Log::info('URL front-end : ' . $front_url);

            //$qrcode = QrCode::size(100)->generate($front_url . '/student/' . $student->id . '/carte');

            Log::info('Rendu de la vue student.carte');
            return view('student.carte', compact('student', 'image', 'sector'));
        } else {
            Log::error('Étudiant non trouvé. Impossible de rendre la vue.');
            // Vous pouvez également renvoyer une vue d'erreur ici si nécessaire
        }
    }


    public function myCarte($id)
    {

        Log::info('Début de la fonction studentCarte');

        $sector = null;
        $student = StudentClasse::where('user_id', $id)->first();

        if ($student) {
            Log::info('Étudiant trouvé. ID : ' . $student->id);
            $sector = $student->mclass->sector;
        } else {
            Log::warning('Étudiant non trouvé pour l\'ID : ' . $id);
        }

        if ($student) {
            Log::info('Récupération de l\'image pour l\'étudiant ID : ' . $student->id);
            $image = Avatar::where("user_id", $student->student->id)->first();

            $front_url = env('SITE_URL');
            Log::info('URL front-end : ' . $front_url);

            //$qrcode = QrCode::size(100)->generate($front_url . '/student/' . $student->id . '/carte');

            Log::info('Rendu de la vue student.carte');
            return view('student.myCarte', compact('student', 'image', 'sector'));
        } else {
            Log::error('Étudiant non trouvé. Impossible de rendre la vue.');
            // Vous pouvez également renvoyer une vue d'erreur ici si nécessaire
        }
    }



    public function downloadCarte($id)
    {
        $student = StudentClasse::where('user_id', $id)->first();

        if (!$student) {
            return response()->json(['error' => 'Étudiant introuvable'], 404);
        }

        if (!$student->student->avatar) {
            return response()->json(['error' => 'Image d\'avatar introuvable'], 404);
        }

        $image = $student->student->avatar;
        $mclass = $student->mclass;
        $sector = $mclass->sector; // Assuming the class name is stored in the `name` column of the `mclasses` table
        $front_url = env('SITE_URL');

        $url = env('SITE_URL') . '/student/' . $student->id . '/carte';

        $data = [
            'student' => $student,
            'url' => $url,
            'image' => $image,
            'sector' => $sector,
        ];

        // Render the view to HTML
        $htmlContent = view('student.carte', $data)->render();

        // Load HTML content into PDF
        $pdfContent = PDF::loadView('student.carte', $data)->setPaper('A4', 'portrait');


        // Return PDF as downloadable file
        return $pdfContent->download($student->student->name . '-carte' . '.pdf');
    }
}
