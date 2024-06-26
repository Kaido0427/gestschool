<?php

namespace App\Http\Controllers;

use App\Helpers\CurrentPromotion;
use App\Models\Matiere;
use App\Models\Mclass;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ClassMatiere;
use App\Models\matiereSemestres;
use App\Models\MatiereTeacher;
use App\Models\Semestre;
use App\Models\semestreUe;
use App\Models\Ue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MatiereController extends Controller
{


    public function classeData(Request $request)
    {
        $currentPromo = CurrentPromotion::currentPromotion()['id'];
        // Récupérer les IDs des professeurs à partir de la requête
        $teacherId = $request->teacher_id;

        // Fetch les professeurs avec les IDs spécifiés
        $teacher = User::find($teacherId);

        // Récupérer la matière
        $matiere = Matiere::find($request->matiere_id);

        // Vérifier si la matière est déjà ajoutée à cette classe
        $checkClassMatiere = ClassMatiere::where('mclass_id', $request->classe_id)
            ->where('matiere_id', $matiere->id)
            ->exists();

        if ($checkClassMatiere) {
            // Vérifier si un enregistrement avec "night" à 1 existe déjà
            $checkClassMatiereNight = ClassMatiere::where('mclass_id', $request->classe_id)
                ->where('matiere_id', $matiere->id)
                ->where('night', 1)
                ->exists();

            if ($checkClassMatiereNight) {
                // Vérifier si un enregistrement avec "night" à 0 existe déjà
                $checkClassMatiereDay = ClassMatiere::where('mclass_id', $request->classe_id)
                    ->where('matiere_id', $matiere->id)
                    ->where('night', 0)
                    ->exists();

                if ($checkClassMatiereDay) {
                    // Un enregistrement avec "night" à 1 et un enregistrement avec "night" à 0 existent déjà, ne rien faire
                    return redirect()->back()->with('error', 'Cette matière a déjà été ajoutée à la classe en journée et en soirée');
                } else {
                    // Créer un nouvel enregistrement avec "night" à 0
                    $classMatiereData = [
                        'mclass_id' => $request->classe_id,
                        'matiere_id' => $matiere->id,
                        'syllabus' => null,
                        'user_id' => $teacherId,
                        'credit_number' => $request->credit_number,
                        'max_note' => $request->max_note,
                        'promotion_id' => $currentPromo,
                        'night' => 0
                    ];

                    ClassMatiere::create($classMatiereData);

                    // Enregistrer les professeurs
                    DB::table('matiere_teachers')->Insert(
                        [
                            'user_id' => $teacherId,
                            'matiere_id' => $matiere->id,
                            'promotion_id' => $currentPromo,
                            'night' => $classMatiereData['night']
                        ]
                    );

                    return redirect()->back()->with('success', 'Les informations ont bien été enregistrées');
                }
            } else {
                // Créer un nouvel enregistrement avec "night" à 1
                $classMatiereData = [
                    'mclass_id' => $request->classe_id,
                    'matiere_id' => $matiere->id,
                    'syllabus' => null,
                    'user_id' => $teacherId,
                    'credit_number' => $request->credit_number,
                    'max_note' => $request->max_note,
                    'promotion_id' => $currentPromo,
                    'night' => 1
                ];

                ClassMatiere::create($classMatiereData);

                // Enregistrer les professeurs
                DB::table('matiere_teachers')->Insert(
                    [
                        'user_id' => $teacherId,
                        'matiere_id' => $matiere->id,
                        'promotion_id' => $currentPromo,
                        'night' => $classMatiereData['night']
                    ]
                );

                return redirect()->back()->with('success', 'Les informations ont bien été enregistrées');
            }
        } else {
            // Créer un nouvel enregistrement avec "night" à 0
            $classMatiereData = [
                'mclass_id' => $request->classe_id,
                'matiere_id' => $matiere->id,
                'syllabus' => null,
                'user_id' => $teacherId,
                'credit_number' => $request->credit_number,
                'max_note' => $request->max_note,
                'promotion_id' => $currentPromo,
                'night' => 0
            ];

            ClassMatiere::create($classMatiereData);

            // Enregistrer les professeurs
            DB::table('matiere_teachers')->Insert(
                [
                    'user_id' => $teacherId,
                    'matiere_id' => $matiere->id,
                    'promotion_id' => $currentPromo
                ]
            );

            return redirect()->back()->with('success', 'Les informations ont bien été enregistrées');
        }
    }

    public function updateClasseData(Request $request, $id)
    {
        $currentPromo = CurrentPromotion::currentPromotion()['id'];

        $classMatiere = ClassMatiere::with('matiere.matiereTeachers')->findOrFail($id);

        // Récupérer les IDs des professeurs à partir de la requête
        $teacherId = $request->teacher_id;

        // Fetch les professeurs avec les IDs spécifiés
        $teacher = User::findOrFail($teacherId);

        // Récupérer la matière
        $matiere = Matiere::find($request->matiere_id);

        // Vérifier si la matière est déjà ajoutée à cette classe
        $checkClassMatiere = ClassMatiere::where('mclass_id', $request->classe_id)
            ->where('matiere_id', $matiere->id)
            ->where('id', '!=', $id)
            ->exists();

        if ($checkClassMatiere) {
            return redirect()->back()->with('error', 'Cette matière a déjà été ajoutée à la classe');
        }

        DB::table('matiere_teachers')
            ->where('matiere_id', $matiere->id)
            ->delete();


        DB::table('matiere_teachers')->updateOrInsert([
            'user_id' => (int) $teacherId,
            'matiere_id' => $matiere->id,
            'promotion_id' => $currentPromo
        ]);


        // Validation des données pour le syllabus s'il est présent
        if ($request->has('syllabus')) {
            $validatedData = $request->validate([
                'syllabus' => 'required|file|mimes:pdf|max:2048',
            ]);
            $file = $request->file('syllabus');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $destinationPath = 'uploads';
            $file->move($destinationPath, $fileName);
        } else {
            $fileName = $classMatiere->syllabus;
        }

        // Mise à jour de la relation ClassMatiere
        $classMatiereData = [
            'mclass_id' => $request->mclass_id,
            'matiere_id' => $matiere->id,
            'syllabus' => $fileName,
            'user_id' => (int) $teacherId,
            'credit_number' => $request->credit_number,
            'max_note' => $request->max_note,
            'promotion_id' => CurrentPromotion::currentPromotion()['id']
        ];

        $classMatiere->update($classMatiereData);

        return redirect()->back()->with('success', 'Les informations ont bien été mises à jour');
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = Mclass::all();
        $matieres = Matiere::all();
        $user = User::find(auth()->user()->id);
        $roles = $user->roles()->select('slug')->get();
        $ues = Ue::all();
        $teachers = User::where('type', 'teacher')->get();
        $ueSemestres = [];


        $classNames = $classes->pluck('name')->toArray(); //Je Récupére les noms de classe sous forme de tableau

        if (count(array_intersect($classNames, ['LU1', 'LU2', 'LU3', 'LC1', 'LC2', 'MFA1', 'MFA2'])) > 0) {
            $max = 30;
        } else {
            $max = 20;
        }

        foreach ($ues as $ue) {
            $ueSemestres[$ue->id] = $ue->semestres;
        }
        $matiereId = request()->input('matiere_id'); // Supposons que vous passiez l'ID de la matière sélectionnée dans la requête
        $matiereSelect = Matiere::find($matiereId);

        return view('matiere', compact('matieres', 'roles', 'max', 'ues', 'teachers', 'ueSemestres', 'matiereSelect'));
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Vérifier si une matière avec le même nom et la même UE existe déjà
        $existingMatiere = Matiere::where('name', $request->input('name'))
            ->where('ue_id', $request->input('ue_id'))
            ->first();

        if ($existingMatiere) {
            return redirect()->back()->with('error', 'Cette matière existe déjà.');
        }

        // Création de la matière avec les données fournies dans la requête
        $matiere = Matiere::create([
            'name' => $request->input('name'),
            'ue_id' => $request->input('ue_id'),
        ]);

        // Vérifier si les semestres sont sélectionnés
        if ($request->has('semestres')) {
            // Récupérer les IDs des semestres sélectionnés
            $semestres = $request->input('semestres');

            // Attacher la matière aux semestres sélectionnés
            $matiere->semestres()->attach($semestres);
        }

        return redirect()->route('matieres.index')->with('success', 'Enregistrement de matière effectué avec succès');
    }







    /**
     * Display the specified resource.
     *
     * @param  \App\Models\matieres  $matieres
     * @return \Illuminate\Http\Response
     */
    public function show(Matiere $matieres)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\matieres  $matieres
     * @return \Illuminate\Http\Response
     */
    public function edit(Matiere $matieres)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\matieres  $matieres
     * @return \Illuminate\Http\Response
     */

    public function updat(Request $request)
    {
        try {
            // Valider et récupérer les données de la requête
            $request->validate([
                'matiere_id' => 'required',
                // Ajoutez ici d'autres règles de validation si nécessaire
            ]);

            // Récupérer la matière à mettre à jour
            $id = $request->input('matiere_id');
            $matiere = Matiere::findOrFail($id);

            // Vérifier si des changements ont été apportés à l'UE, au nom de la matière ou aux semestres
            $updatedData = [];
            if ($request->filled('ue_id') && ($matiere->ue_id != $request->input('ue_id') || $matiere->name != $request->input('name') || $matiere->semestres->pluck('id')->toArray() != $request->input('semestres'))) {
                $updatedData['name'] = $request->input('name');
                $updatedData['ue_id'] = $request->input('ue_id');
                $updatedData['semestres'] = $request->input('semestres');

                Log::info('UE, nom de la matière ou semestres ont changé.');
                Log::info('Nouvelles données : ' . json_encode($updatedData));

                // Synchroniser les nouveaux semestres liés à la matière
                if (!empty($updatedData['semestres'])) {
                    $semestres = $updatedData['semestres'];
                    $matiere->semestres()->sync($semestres);

                    Log::info('Synchronisation des nouveaux semestres.');
                    Log::info('Nouveaux semestres synchronisés : ' . json_encode($semestres));

                    // Vérifier si des affectations doivent être supprimées
                    $classMatiere = ClassMatiere::where('matiere_id', $matiere->id)->first();

                    if ($classMatiere) {
                        $classSemesters = $classMatiere->semestres->pluck('id')->toArray();
                        $previousSemesters = $matiere->semestres->pluck('id')->toArray();
                        $semestersToRemove = array_diff($previousSemesters, $classSemesters);

                        Log::info('Semestres à supprimer : ' . json_encode($semestersToRemove));

                        foreach ($semestersToRemove as $semesterToRemove) {
                            if (!in_array($semesterToRemove, $semestres)) {
                                // Supprimer l'affectation pour ce semestre
                                $currentPromo = CurrentPromotion::currentPromotion()['id'];

                                DB::table('matiere_teachers')
                                    ->where('matiere_id', $matiere->id)
                                    ->where('promotion_id', $currentPromo)
                                    ->delete();

                                $classMatiere->delete();


                                Log::info('Affectations supprimées pour le semestre retiré de la classe.');
                                Log::info('Semestre retiré de la classe : ' . $semesterToRemove);

                                return redirect()->route('matieres.index')->with('warning', 'Attention : une réaffectation est nécessaire car la matière a été retirée d\'un semestre de la classe.' . $classMatiere->classe->name . ' ');
                            }
                        }
                    }
                    $messageType = 'warning';
                    $message = 'Attention : une réaffectation est nécessaire car la matière a été retirée d\'un semestre de la classe.';
                } else {
                    $matiere->save();
                    $messageType = 'success';
                    $message = 'Matière mise à jour avec succès';
                }
            } else {
                $matiere->save();
                $messageType = 'success';
                $message = 'Matière mise à jour avec succès';
            }

            // Redirection avec le message approprié
            return redirect()->route('matieres.index')->with($messageType, $message);
        } catch (\Exception $e) {
            // Gérer les erreurs éventuelles
            Log::error('Une exception s\'est produite : ' . $e->getMessage());
            return redirect()->route('matieres.index')->with('error', 'Une erreur est survenue lors de la mise à jour de la matière.');
        }
    }
    public function update(Request $request)
    {
        try {
            $request->validate([
                'matiere_id' => 'required',
                'name' => 'required',
                'ue_id' => 'required',
                'semestres' => 'array',
            ]);

            $matiere = Matiere::findOrFail($request->input('matiere_id'));


            //SECTION  A REVISER(kaido_2704)

            // $classMatiere = ClassMatiere::where('matiere_id', $matiere->id)->first();


            /*  $semestresCount = $classMatiere->semestres()->count();

            if ($semestresCount > 0) {
                foreach ($request->input('semestres', []) as $semestreId) {
                    $semestre = Semestre::findOrFail($semestreId);

                    if ($semestre->level->id != $classMatiere->classe->level_id) {
                        $classMatiere->delete();
                        return redirect()->route('matieres.index')->with('warning', 'La classe de la matière a été supprimée car elle n\'est plus liée au niveau du semestre.');
                    }
                }
            }*/


            // Si la classe de matière existe encore ou s'il n'y a pas de semestres liés
            $matiere->update([
                'name' => $request->input('name'),
                'ue_id' => $request->input('ue_id'),
            ]);

            $matiere->semestres()->sync($request->input('semestres', []));

            return redirect()->route('matieres.index')->with('success', 'Mise à jour effectuée avec succès!');
        } catch (\Exception $e) {
            Log::error('Une exception s\'est produite : ' . $e->getMessage());
            return redirect()->route('matieres.index')->with('error', 'Une erreur est survenue lors de la mise à jour de la matière.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\matieres  $matieres
     * @return \Illuminate\Http\Response
     */
    public function destroy(Matiere $matieres)
    {
        //
    }
}
