<?php

namespace App\Http\Controllers\Personal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Personalcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $personals= User::where('type','personal')->get();

        $user = User::find(auth()->user()->id);
        $roles = $user->roles()->select('slug')->get();        
        return view('personal.index', compact('personals', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('personal.create', compact('roles'));
        
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
            'firstname' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'email' => 'required|email',
        ]);

        $roleIds = $request->role_id; 
        //dd($request->input(['role_id']));
        // je crée un mot de passe par défaut pour tous le personnel 
        $request['password']="Person@l";

        $request['type']="personal";

        $personalData = $request->all();
       
        unset($personalData['role_id']);

        $user = User::create($personalData);

        $user->roles()->attach($roleIds);

        return redirect()->route('personals.create')->with('success','Enregistrement du personnel effectué avec succes');
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
        $personal = User::find($id);
        
        $roles = Role::select("*")
        ->whereNotIn('id', $personal->getRoleIds())
        ->get();
        return view('personal.edit', compact('personal', 'roles'));
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
        $personal = User::find($id);

        $personalData = $request->all();
        $AddRoleIds = $request->roles_id; 
        $detachRoleIds = $request->detach_role_id; 
        unset($personalData['roles_id']);
        unset($personalData['detach_role_id']);
        $personal->update($personalData);
        $personal->roles()->toggle($AddRoleIds);
        $personal->roles()->toggle($detachRoleIds);
        return redirect()->back()->with('success','Modification effectué avec succès');
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

    public function dashboard  ()
    {
        return view('personal.dashboard');
    }
}
