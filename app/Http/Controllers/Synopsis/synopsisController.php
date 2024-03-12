<?php

namespace App\Http\Controllers\Synopsis;

use App\Helpers\CurrentPromotion;
use App\Http\Controllers\Controller;
use App\Models\ClassMatiere;
use App\Models\Matiere;
use App\Models\Semestre;
use App\Models\StudentClasse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class synopsisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Récupérer toutes les matières avec leurs classes et enseignants
        $matieres = Matiere::with(['classes', 'teacher'])->get();

        // Je Récupére l'ID de la promotion actuelle 
        $currentPromotionId = CurrentPromotion::currentPromotion()['id'];

        // Je Récupére les IDs des matières pour la promotion actuelle
        $matiereClasses = ClassMatiere::where('promotion_id', $currentPromotionId)->get();
        $matiereIds = $matiereClasses->pluck('matiere_id')->unique();

        // j Récupére les semestres pour les niveaux Licence 1 et Licence 2
        $semestreWithMatieresL1L2 = $this->getSemestresByLevel('%Licence 1%', '%Licence 2%', $matiereIds);

        // ||
        $semestreWithMatieresL3 = $this->getSemestresByLevel('Licence 3', null, $matiereIds);

        // je Récupére les semestres pour le niveau Licence Canonique
        $semestreWithMatieresLcano = $this->getSemestresByLevel('%Licence Canonique%', null, $matiereIds);

        // je Récupére les semestres pour les niveaux Master
        $semestreWithMatieresMastere = $this->getSemestresByLevel('%Master%', null, $matiereIds);



        return view('synopsis.index', compact('matieres', 'semestreWithMatieresL1L2', 'semestreWithMatieresL3', 'semestreWithMatieresLcano', 'semestreWithMatieresMastere'));
    }

    // Fonction pour récupérer les semestres par niveau
    private function getSemestresByLevel($levelName1, $levelName2, $matiereIds)
    {
        return Semestre::with(['ues' => function ($query) use ($matiereIds) {
            $query->with(['matieres' => function ($matiere) use ($matiereIds) {
                $matiere->whereIn('id', $matiereIds)->with(['matiereTeachers' => function ($mt) {
                    $mt->with('teacher');
                }])->orderBy('id', 'desc');
            }]);
        }])->whereHas('level', function ($level) use ($levelName1, $levelName2) {
            if ($levelName2) {
                $level->where('name', 'like', $levelName1)->orWhere('name', 'like', $levelName2);
            } else {
                $level->where('name', 'like', $levelName1);
            }
        })->get();
    }


    public function classSynopsis()
    {
        // je récupere le niveau d'étude de l'étudiant connecter
        $authUser = User::where('id', Auth::user()->id)->first();

        $userCurrentClasse = $authUser->studentPromotionClasses()->where('promotion_id', CurrentPromotion::currentPromotion()['id'])
            ->with('mclass', function ($query) {
                $query->with('level');
            })->first();

        $matieres = Matiere::with(['classes', 'teacher'])->get();

        $semestreWithMatieres = Semestre::where('level_id', $userCurrentClasse->mclass->level_id)->with(['ues' => function ($query) {
            $query->with([
                'matieres' => function ($matiere) {

                    $matiere->with(['matiereTeachers' => function ($mt) {
                        $mt->with('teacher')->where('promotion_id', CurrentPromotion::currentPromotion()['id']);
                    }])->orderBy('id', 'desc');
                }
            ]);
        }])->get();


        return view('synopsis.student', compact('matieres', 'semestreWithMatieres'));
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
        //
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
