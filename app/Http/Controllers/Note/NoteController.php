<?php

namespace App\Http\Controllers\Note;

use App\Helpers\CurrentPromotion;
use App\Http\Controllers\Controller;
use App\Models\ClassMatiere;
use App\Models\MatiereTeacher;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mclass;
use App\Models\Matiere;
use App\Models\Evaluate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($classe, $matiere, $matricule)
    {
        $classe = Mclass::where('id', $classe)->first();
        $classMatiere = ClassMatiere::where('mclass_id', $classe['id'])->where('matiere_id', $matiere)->first();
        //        'mclass_id', 'matiere_id',
        $mymatiere = MatiereTeacher::where('matiere_id', $classMatiere->matiere_id)->where('user_id', Auth::user()->id)->first();

        $user = User::where('matricule', $matricule)->first();

        $note = Evaluate::where("matiere_id", $mymatiere["matiere_id"])->where('user_id', $user['id'])->first();
        // dd($myclass, $mymatiere, $user);
        return view('note.create', compact('classe', 'mymatiere', 'user', 'note', 'classMatiere'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
    {
        try {
            Log::info('Début de la fonction store');

            // Récupérer la classe et la matière
            $classe = Mclass::where('id', $request['classe_id'])->first();
            if (!$classe) {
                throw new \Exception("Classe introuvable avec l'ID " . $request['classe_id']);
            }
            Log::info('Classe récupérée', ['classe' => $classe]);

            $matiere = Matiere::where('id', $request['matiere_id'])->first();
            if (!$matiere) {
                throw new \Exception("Matière introuvable avec l'ID " . $request['matiere_id']);
            }
            Log::info('Matière récupérée', ['matiere' => $matiere]);

            // Vérifier si l'enseignant enseigne cette matière dans cette classe (MatiereTeacher)
            $matiereTeacher = MatiereTeacher::where('matiere_id', $matiere->id)
                ->where('user_id', Auth::user()->id)
                ->first();

            if (!$matiereTeacher) {
                throw new \Exception('Vous n\'êtes pas autorisé à enregistrer une note pour cette matière et cette classe.');
            }
            Log::info('MatiereTeacher récupérée', ['matiereTeacher' => $matiereTeacher]);

            // Récupérer le bon cours (ClassMatiere) en fonction du créneau (jour/nuit)
            $classMatiere = ClassMatiere::where('mclass_id', $classe->id)
                ->where('matiere_id', $matiere->id)
                ->where('night', $matiereTeacher->night)
                ->first();

            if (!$classMatiere) {
                throw new \Exception('Cette matière n\'est pas enseignée dans cette classe pour le créneau sélectionné.');
            }
            Log::info('ClassMatiere récupérée', ['classMatiere' => $classMatiere]);

            // Vérifier si la note existe déjà pour l'étudiant dans cette matière et cette classe
            $note = Evaluate::where('matiere_id', $matiere->id)
                ->where('user_id', $request['user_id'])
                ->where('promotion_id', CurrentPromotion::currentPromotion()->id)
                ->first();

            Log::info('Note existante récupérée', ['note' => $note]);

            // Préparer les données de la note
            $data = $this->prepareNoteData($request, $note, $matiereTeacher->night, $classMatiere->id);

            Log::info('Données préparées', ['data' => $data]);

            if ($note) {
                // Une note existe déjà
                if ($matiereTeacher->night != $note->night) {
                    // Le créneau a changé (jour -> nuit ou nuit -> jour)
                    Log::info('Mise à jour de la note avec le nouveau créneau', ['note' => $note]);
                    $note->update($data);
                } else {
                    // Le créneau est le même
                    Log::info('Mise à jour de la note existante', ['note' => $note]);
                    $note->update($data);
                }
            } else {
                // Aucune note n'existe
                Log::info('Création d\'une nouvelle note', ['data' => $data]);
                Evaluate::create($data);
            }

            Log::info('Note enregistrée avec succès');

            return redirect()->back()->with('success', 'Note enregistrée avec succès');
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'enregistrement de la note', ['message' => $e->getMessage()]);
            return redirect()->back()->withErrors('Une erreur est survenue lors de l\'enregistrement de la note.');
        }
    }

    private function prepareNoteData(Request $request, $note, $matiereTeacherNight, $coursId)
    {
        $data = $request->all();
        $data['promotion_id'] = CurrentPromotion::currentPromotion()->id;
        $data['cours_id'] = $coursId; // Ajouter le cours_id correspondant

        if ($request->type == "examen") {
            $data['examen'] = $request['note'] * 0.6;
        } else {
            $data['controle'] = $request['note'] * 0.4;
        }

        unset($data['note']);
        unset($data['type']);

        // Si la note existe déjà, ne pas mettre à jour les champs user_id et matiere_id
        if ($note) {
            unset($data['user_id']);
            unset($data['matiere_id']);
        }

        $data['night'] = $matiereTeacherNight;

        return $data;
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
        //
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
        //
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
