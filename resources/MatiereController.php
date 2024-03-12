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
            return redirect()->back()->with('error', 'Cette matière a déjà été ajoutée à la classe');
        }


        DB::table('matiere_teachers')->Insert(
            [
                'user_id' => $teacherId,
                'matiere_id' => $matiere->id,
                'promotion_id' => $currentPromo
            ]
        );


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
            $fileName = null;
        }

        // Création de la relation ClassMatiere
        $classMatiereData = [
            'mclass_id' => $request->classe_id,
            'matiere_id' => $matiere->id,
            'syllabus' => $fileName,
            'user_id' => $teacherId,
            'credit_number' => $request->credit_number,
            'max_note' => $request->max_note,
            'promotion_id' => CurrentPromotion::currentPromotion()['id']
        ];

        ClassMatiere::create($classMatiereData);

        return redirect()->back()->with('success', 'Les informations ont bien été enregistrées');
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
        $matieres = Matiere::all();
        $user = User::find(auth()->user()->id);
        $roles = $user->roles()->select('slug')->get();
        $ues = Ue::all();
        $teachers = User::where('type', 'teacher')->get();
        $ueSemestres = [];

        foreach ($ues as $ue) {
            $ueSemestres[$ue->id] = $ue->semestres;
        }
        $matiereId = request()->input('matiere_id'); // Supposons que vous passiez l'ID de la matière sélectionnée dans la requête
        $matiereSelect = Matiere::find($matiereId);

        return view('matiere', compact('matieres', 'roles', 'ues', 'teachers', 'ueSemestres', 'matiereSelect'));
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
            // Valider et récupérer les données de la requête
            $request->validate([
                'matiere_id' => 'required',
                // Ajoutez ici d'autres règles de validation si nécessaire
            ]);

            // Récupérer la matière à mettre à jour
            $matiere = Matiere::findOrFail($request->input('matiere_id'));

            // Vérifier si des changements ont été apportés à l'UE, au nom de la matière ou aux semestres
            $updatedData = [
                'name' => $request->input('name'),
                'ue_id' => $request->input('ue_id'),
                'semestres' => $request->input('semestres'),
            ];

            Log::info('Nouvelles données : ' . json_encode($updatedData));

            // Synchroniser les nouveaux semestres liés à la matière
            if (!empty($updatedData['semestres'])) {
                $semestres = $updatedData['semestres'];

                // Vérifier si des affectations doivent être supprimées
                $classMatiere = ClassMatiere::where('matiere_id', $matiere->id)->first();
                if ($classMatiere) {
                    $classSemesters = $classMatiere->semestres->pluck('id')->toArray();
                    $semestresToRemove = array_diff($matiere->semestres->pluck('id')->toArray(), $classSemesters);

                    if (count($semestresToRemove) > 0 && empty(array_diff($semestres, $classSemesters))) {
                        Log::info('Au moins un semestre de la matière est toujours lié à la classe.');
                        $messageType = 'info';
                        $message = 'Aucune affectation n\'a été supprimée.';
                    } else {
                        // Supprimer l'affectation uniquement si aucun semestre lié à la matière n'est encore lié à la classe
                        $remainingSemesters = array_diff($matiere->semestres->pluck('id')->toArray(), $semestresToRemove);
                        if (empty(array_intersect($remainingSemesters, $classSemesters))) {
                            $classMatiere->delete();
                            Log::info('Affectations supprimées pour les semestres retirés de la classe.');
                            $messageType = 'warning';
                            $message = 'Toutes les affectations de la matière ont été supprimées car la matière a été retirée de tous les semestres de la classe.';
                        } else {
                            // Dans le cas où au moins un semestre est toujours lié à la classe, ne supprimez pas l'affectation
                            Log::info('Au moins un semestre de la matière est toujours lié à la classe.');
                            $messageType = 'info';
                            $message = 'Aucune affectation n\'a été supprimée.';
                        }
                    }
                }

                // Mettre à jour les semestres de la matière
                $matiere->semestres()->sync($semestres);
                Log::info('Nouveaux semestres synchronisés : ' . json_encode($semestres));
            }

            // Mettre à jour les autres données de la matière
            $matiere->name = $updatedData['name'];
            $matiere->ue_id = $updatedData['ue_id'];
            $matiere->save();

            Log::info('Matière mise à jour avec succès.');

            // Redirection avec le message approprié
            return redirect()->route('matieres.index')->with($messageType ?? 'success', $message ?? 'Matière mise à jour avec succès');
        } catch (\Exception $e) {
            // Gérer les erreurs éventuelles
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
