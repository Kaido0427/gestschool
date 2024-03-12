<?php

namespace App\Http\Controllers;

use App\Models\Matiere;
use Illuminate\Http\Request;
use App\Models\Semestre;
use App\Models\Ue;
use App\Models\User;

class UeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ues = Ue::with(['semestres'])->get();

        $user = User::find(auth()->user()->id);
        $semestres = Semestre::all();
        $roles = $user->roles()->select('slug')->get();

        //dd($filtered_arr);
        return view('ue.index', compact('ues', 'roles', 'semestres'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $semestres = Semestre::all();

        return view('ue.create', compact('semestres'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Vérifier si l'UE existe déjà avec le même nom
        $ue = Ue::where('name', $request->input('name'))->first();

        // Si l'UE n'existe pas, la créer
        if (!$ue) {
            $ue = UE::create([
                'name' => $request->input('name'),
                'type' => $request->input('type'),
                'code' => $request->input('code'),
            ]);
        }

        // Récupérer les semestres sélectionnés
        $semestresIds = $request->input('semestres', []);

        // Attacher les semestres à l'UE
        $ue->semestres()->syncWithoutDetaching($semestresIds);

        return redirect()->route('ues.index')->with('success', 'Enregistrement de matière effectué avec succès');
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
        $ue = Ue::find($id);
        $semestres = Semestre::all();

        return view('ue.edit', compact('ue', 'semestres'));
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
        $ue = Ue::find($id);
        $ue->update([
            'name' => $request->input('name'),
            'type' => $request->input('type'),
            'code' => $request->input('code'),
        ]);

        // Récupérer les semestres sélectionnés
        $semestresIds = $request->input('semestres', []);

        // Attacher les semestres à l'UE
        $ue->semestres()->sync($semestresIds);

        return redirect()->route('ues.index')->with('success', 'Modification effectuée avec succès');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ue = Ue::find($id);

        $ue->delete();

        return redirect()->route('ues.index')->with('success', 'Ue supprimer avec succès');
    }

    public function semestres(Ue $ue, Matiere $mat)
    {
        // Récupérer les semestres liés à l'UE
        $semestresUE = $ue->semestres()->with('level')->get()->unique('id');

        // Récupérer les semestres liés à la matière sélectionnée
        $semestresMatiere = $mat->semestres()->with('level')->get()->unique('id');

        // Marquer les semestres liés à la matière sélectionnée
        $semestresUE = $semestresUE->map(function ($semestre) use ($semestresMatiere) {
            $semestre->mat_matiere = $semestresMatiere->contains('id', $semestre->id);
            return $semestre;
        });

        // Préparer les données à renvoyer
        $formattedSemestres = $semestresUE->map(function ($semestre) {
            return [
                'id' => $semestre->id,
                'name' => $semestre->name,
                'level_code' => $semestre->level->code, // Accéder au nom du niveau d'étude du semestre
                'mat_matiere' => $semestre->mat_matiere, // Indiquer si le semestre est lié à la matière sélectionnée
            ];
        });

        // Retourner les données au format JSON
        return response()->json($formattedSemestres);
    }
}
