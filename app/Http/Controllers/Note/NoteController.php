<?php

namespace App\Http\Controllers\Note;

use App\Helpers\CurrentPromotion;
use App\Http\Controllers\Controller;
use App\Models\ClassMatiere;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mclass;
use App\Models\Matiere;
use App\Models\Evaluate;

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
        $mymatiere = Matiere::find($matiere);
        $user = User::where('matricule', $matricule)->first();

        $note = Evaluate::where("matiere_id", $mymatiere["id"])->where('user_id', $user['id'])->first();
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
        $note = Evaluate::where("matiere_id", $request['matiere_id'])
        ->where('user_id', $request['user_id'])
        ->where('promotion_id', CurrentPromotion::currentPromotion()->id)
        ->first();
        $request['promotion_id'] = CurrentPromotion::currentPromotion()->id;
        if ($request->type == "examen") {
            $request['examen'] = $request['note'] * 0.6;
        } else {
            $request['controle'] = $request['note'] * 0.4;
            //examen
        }
        $data = $request->all();
        // $data["promotion_id"] = CurrentPromotion::currentPromotion()->id;
        unset($data['note']);
        unset($data['type']);
        if (!$note) {
            Evaluate::create($data);
        } else {
            unset($data['user_id']);
            unset($data['matiere_id']);
            //dd($data);
            $note->update($data);
        }


        return redirect()->back()->with('success', 'Note enregistrer avec succès');
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
