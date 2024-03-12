<?php

namespace App\Http\Controllers;

use App\Helpers\CurrentPromotion;
use App\Models\Mclass;
use Illuminate\Http\Request;
use App\Models\Level;
use App\Models\Sector;
use App\Models\Matiere;
use App\Models\User;
use App\Models\ClassMatiere;
use App\Models\Semestre;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MclassController extends Controller
{

    public function showAddMatieresForm()
    {
    }
    public function matieresold($id)
    {
        $classe = Mclass::with('matieres')->findOrFail($id);
        //recuperer les id des matieres de la classe 
        $matieres = Matiere::all();

        $matiereIds = ClassMatiere::where('mclass_id', $classe['id'])->pluck('matiere_id');

        $matieres = Matiere::whereNotIn('id', $matiereIds)->whereHas('ue', function ($query) use ($classe) {
            $query->whereHas('semestres', function ($query) use ($classe) {
                $query->where('level_id', $classe['level_id']);
            });
        })->get();

        $teachers = User::Where('type', 'teacher')->get();
        $classeWithMatieres = ClassMatiere::with(['matiere' => function ($query) {
            $query->with('matiereTeachers.teacher');
        }])
            ->where('mclass_id', $id)
            ->where('promotion_id', CurrentPromotion::currentPromotion()['id'])
            ->get();

        $getClasse = DB::table('mclasses')
            ->join("matiere_mclass", "mclasses.id", "=", "matiere_mclass.mclass_id")
            ->join("users", "users.id", "=",  "matiere_mclass.user_id")
            ->join("matieres", "matieres.id", "=",  "matiere_mclass.matiere_id")
            ->select("users.*", "matieres.name as matiere", "matiere_mclass.*")
            ->where('mclasses.id', '=', $id)
            ->get();


        return view('classe.matieres', compact('matieres', 'teachers', 'getClasse', 'classeWithMatieres'))->with('classe', $classe);
    }

    public function matieres($id)
    {
        $classe = Mclass::with('matieres')->findOrFail($id);

        // je recup les IDs de matières associées à la classe
        $matiereIds = ClassMatiere::where('mclass_id', $classe->id)->pluck('matiere_id');

        // je recup les IDs de matières associées aux semestres de la classe
        $matieresSemestreIds = Semestre::where('level_id', $classe->level_id)
            ->with('matieres')
            ->get()
            ->flatMap(function ($semestre) {
                return $semestre->matieres->pluck('id');
            });

        // Je filtres les matières qui ne sont pas associées à la classe
        $matieres = Matiere::whereNotIn('id', $matiereIds)
            ->whereIn('id', $matieresSemestreIds)
            ->get();

        $semestres = Semestre::with('matieres')
            ->where('level_id', $classe->level_id)
            ->get();

        $teachers = User::where('type', 'teacher')->get();

        $classeWithMatieres = ClassMatiere::with(['matiere' => function ($query) {
            $query->with(['matiereTeachers.teacher']);
        }])
            ->where('mclass_id', $id)
            ->where('promotion_id', CurrentPromotion::currentPromotion()['id'])
            ->get();

        return view('classe.matieres', compact('classe', 'matiereIds', 'matieres', 'semestres', 'teachers', 'classeWithMatieres'));
    }

    public function deleteMatiere($matiere, $classe)
    {
        $currentPromo = CurrentPromotion::currentPromotion()['id'];
        $matiereClasse = ClassMatiere::where('mclass_id', $classe)->where('matiere_id', $matiere)->first();

        if ($matiereClasse) {

            // Supprimer les anciennes relations matiere_teachers pour cette matière et cette promotion
            DB::table('matiere_teachers')
                ->where('matiere_id', $matiere)
                ->where('promotion_id', $currentPromo)
                ->delete();

            $matiereClasse->delete();
        }
        return redirect()->route('matieres-classe', ['id' => $classe])->with('success', 'suppression effectuée avec succès');
    }
    public function showAddFile($id)
    {
        $classe = Mclass::find($id);
        return view('classe.add-time-usage', compact('classe'));
    }
    public function students($id)
    {
        $classe = Mclass::with(['students' => function ($query) {
            $query->where('promotion_id', CurrentPromotion::currentPromotion()->id);
        }])->where('id', $id)->first();

        // dd($students);

        return view('classe.students', compact('classe'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_file(Request $request)
    {
        //dd("j");
    }
    public function index()
    {
        $levels = Level::All();

        $classes = Mclass::with(['students' => function ($student) {
            $student->where('promotion_id', CurrentPromotion::currentPromotion()->id);
        }, 'level', 'sector'])
            ->get();
        $user = User::find(auth()->user()->id);
        $roles = $user->roles()->select('slug')->get();
        //dd($classes);
        $sectors = Sector::All();

        return view('classe.index', compact('classes', 'levels', 'sectors', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $sector = Sector::find($request->sector_id)->code;

        $levels = Level::find($request->level_id)->code;

        $request["name"] = $sector . "-" . $levels;

        Mclass::create($request->all(), ['name' => $request->name]);

        return redirect()->route('classes.index')->with('success', 'Enregistrement de classe effectué avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mclass  $mclass
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $classe = Mclass::find($id);

        return view('classe.modified')->with('classe', $classe);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mclass  $mclass
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $levels = Level::all();
        $classes = Mclass::with(['students' => function ($student) {
            $student->where('promotion_id', CurrentPromotion::currentPromotion()->id);
        }, 'level', 'sector'])->find($id);

        if (!$classes) {
            return redirect()->route('classes.index')->with('error', 'Classe non trouvée');
        }
        $user = User::find(Auth::user()->id);
        $roles = $user->roles()->select('slug')->get();
        $sectors = Sector::all();


        return view('classe.edit', compact('classes', 'levels', 'sectors', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mclass  $mclass
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $mclass)
    {
        $mclass = Mclass::find($mclass);

        $mclass->update($request->all());
        //dd('mclass', $mclass);

        return redirect()->route('classes.index')->with('success', 'Modification de classe effectué avec succès');
    }
    public function addFile(Request $request)
    {
        $validatedData = $request->validate([
            'file' => 'file|max:2048',
        ]);


        $file = $request->file('time_usage');

        $fileName   = time() . $file->getClientOriginalName();

        $destinationPath = 'uploads';
        $file->move($destinationPath, $fileName);
        $myclass = Mclass::find($request->id);
        $myclass['time_usage'] = $fileName;
        $myclass->save();


        return redirect()->route('classes.index')->with('success', 'Emploie du temps bien ajouter');
    }

    public function modified($id)
    {

        // Supposons que $classMatiereId contienne l'ID de la ClassMatiere
        $classMatiere = ClassMatiere::find($id);

        if ($classMatiere) {
            $classe = $classMatiere->classe;
        } else {

            echo "La ClassMatiere avec cet ID n'existe pas.";
        }
        $matieres = Matiere::all();
        $teachers = User::where('type', 'teacher')->get();

        $classeMatieres = ClassMatiere::with(['matiere' => function ($query) {
            $query->with('matiereTeachers.teacher');
        }])
            ->where('mclass_id', $id)
            ->where('promotion_id', CurrentPromotion::currentPromotion()['id'])
            ->get();

        $semestres = Semestre::with('matieres')
            ->where('level_id', $classe->level_id)
            ->get();

        return view('classe.modified', compact('classeMatieres', 'classMatiere', 'classe', 'matieres', 'teachers','semestres'));
    }





    public function editClassData($id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mclass  $mclass
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mclass $mclass)
    {
        //
    }
}
