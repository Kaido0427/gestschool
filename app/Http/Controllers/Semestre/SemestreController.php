<?php

namespace App\Http\Controllers\Semestre;

use App\Http\Controllers\Controller;
use App\Models\Level;
use Illuminate\Http\Request;

use App\Models\Semestre;
use App\Models\Ue;
use App\Models\User;

class SemestreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $semestres = Semestre::All();
        $levels = Level::all();
        $user = User::find(auth()->user()->id);
        $roles = $user->roles()->select('slug')->get();

        //dd($filtered_arr);
        return view('semestre.index', compact('semestres', 'roles', 'levels'));
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

        Semestre::create($request->all());

        return redirect()->route('semestres.index')->with('success', 'Semestre enregistrer avec succès');
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
        $levels=Level::all();
        $semestre = Semestre::find($id);

        return view('semestre.edit', compact('semestre','levels'));
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
        $semestre = Semestre::find($id);
        $semestre->update($request->all());

        return redirect()->route('semestres.index')->with('success', 'semestre  mise à jour avec succès');
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
