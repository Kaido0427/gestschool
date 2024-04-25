<?php

namespace App\Http\Controllers\Teacher;

use App\Helpers\CurrentPromotion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mclass;
use App\Models\ClassMatiere;
use App\Models\Matiere;
use App\Models\MatiereTeacher;
use App\Models\StudentClasse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $teachers = User::where('type', 'teacher')->get();
        $user = User::find(auth()->user()->id);
        $roles = $user->roles()->select('slug')->get();
        return view('teacher.index', compact('teachers', 'roles'));
    }

    public function signUp()
    {
        return view('teacher.inscrire');
    }

    public function save(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'firstname' => 'required',
            'gender' => 'required',
        ]);
        // je crée un mot de passe par défaut pour tous les professeurs 
        $request['type'] = "teacher";

        $user = User::create($request->all());

        return redirect()->back()->with('success', 'Votre compte a été créé');
    }
    public function classes()
    {
        if (auth()->user() && auth()->user()->type == "teacher") {

            $classByTeacher = ClassMatiere::with(['matiere' => function ($query) {
                $query->with(['matiereTeachers.teacher']);
            }])
                ->where('user_id', Auth::user()->id)
                ->where('promotion_id', CurrentPromotion::currentPromotion()['id'])
                ->get();


            return view('teacher.classe', compact('classByTeacher'));
        }
        return redirect()->intended('/teacher-login');
    }

    public function students($teacher, $matiere, $classe)
    {

        $cours = ClassMatiere::where('matiere_id', $matiere)->where('user_id', auth()->user()->id)->first();
        $matiereId = $cours->matiere_id;
        $teacher = MatiereTeacher::where('user_id', $teacher)->first();
        //dd($matiere, intval($matiere));
        $students = StudentClasse::where('promotion_id', CurrentPromotion::currentPromotion()->id)
            ->where('mclass_id', $classe)
            ->with('student', function ($std) use ($matiereId) {
                $std->with(['evaluation' => function ($e)  use ($matiereId) {
                    $e->where('matiere_id', $matiereId);
                }]);
            })->get();

        //dd($teacher);
        return view('teacher.students', compact('students', 'matiere','teacher','cours'));
    }
    public function dashboard()
    {
        if (auth()->user() && auth()->user()->type == "teacher") {

            $classByTeacher = ClassMatiere::with(['matiere' => function ($query) {
                $query->with(['matiereTeachers.teacher']);
            }])
                ->where('user_id', Auth::user()->id)
                ->where('promotion_id', CurrentPromotion::currentPromotion()['id'])
                ->get();


            return view('teacher.dashboard', compact('classByTeacher'));
        }
        return redirect()->intended('/teacher-login');
    }


    public function logout()
    {
        Auth::logout();

        return redirect('login');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('teacher.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'email' => 'required|email',
        ]);

        // Créer un mot de passe par défaut pour tous les professeurs 
        $request['password'] = "Pr@fesseur";
        $request['type'] = "teacher";

        // Créer l'utilisateur en tant que professeur
        $userData = $request->only(['name', "firstname", 'address', 'email', 'phone', "gender", "password", 'type']);
        $userData['mclasse_id'] = null; // ou une valeur par défaut appropriée si nécessaire
        $user = User::create($userData);

        return redirect()->route('teachers.create')->with('success', 'Enregistrement de professeur effectué avec succès');
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
        $teacher = User::find($id);

        return view('teacher.edit', compact('teacher'));
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
        $this->validate(request(), [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'email' => 'required|email',
        ]);

        // Récupérer l'utilisateur à mettre à jour
        $user = User::findOrFail($id);

        // Mettre à jour les champs de l'utilisateur
        $user->name = $request->input('name');
        $user->firstname = $request->input('firstname');
        $user->address = $request->input('address');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->gender = $request->input('gender');

        // Sauvegarder les modifications
        $user->save();

        return redirect()->route('teachers.edit', $id)->with('success', 'Profil du professeur mis à jour avec succès');
    }

    public function editSyllabus($classe)
    {
        // Je récupère la classeMatiere $myClass dans laquelle enseigne le professeur connecté
        $myClass = ClassMatiere::where('user_id', auth()->user()->id)
            ->findOrFail($classe);
        return view('teacher.addSyllabus', compact('myClass'));
    }


    public function addSyllabus(Request $request, $classe, $id)
    {
        try {
            $request->validate([
                'syllabus' => 'required|file|mimes:pdf|max:2048',
            ]);
            // Je récupère la matiere et la  classe à laquelle le professeur est affecté
            $myClass = ClassMatiere::where('user_id', auth()->user()->id)
                ->where('matiere_id', $id)
                ->findOrFail($classe);

            if (!$myClass) {
                return view('teacher.dashboard')->with('error', 'Aucune classe trouvée !!');
            }

            // Je vérifie d'abord si un syllabus existe déjà
            if ($myClass->syllabus) {
                // Si un syllabus existe déjà, je supprime le fichier précédent
                Storage::delete('uploads/' . $myClass->syllabus);
            }

            // Je récupère ensuite le fichier depuis le formulaire
            $file = $request->file('syllabus');

            // Je crée un nom de fichier unique pour le syllabus
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Chemin pour le fichier
            $destinationPath = 'uploads';

            // Je déplace le fichier vers le chemin spécifié
            $file->move($destinationPath, $fileName);

            // Je mets à jour le champ syllabus pour la classe concernée
            $myClass->update(['syllabus' => $fileName]);

            return redirect()->route('teacher.dasboard')->with('success', 'Syllabus mis à jour avec succès!');
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'ajout du syllabus : ' . $e->getMessage());
            return redirect()->route('teacher.dasboard')->with('error', 'Une erreur est survenue lors de l\'ajout du syllabus.');
        }
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
}
