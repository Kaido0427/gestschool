<?php

namespace App\Http\Controllers\Information;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mclass;
use App\Models\Information;

class InformationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $informations ="";
        if (auth()->user()->type === "admin" ) {

            $informations = Information::orderBy('created_at','desc')->get();

        } elseif (auth()->user()->type == "teacher") {

            $informations = Information::where('shared_with', 'teachers')->orWhere('shared_with', 'all')->orderBy('created_at','desc')->get();

        }elseif(auth()->user()->type == "student"){

            $informations = Information::where('shared_with', 'students')->orWhere('shared_with', 'all')
            ->orWhere('shared_with', auth()->user()->mclasse_id)->orderBy('created_at','desc')->get();
        }elseif( auth()->user()->type == "personal"){

            $informations = Information::where('shared_with', 'personals')->orWhere('shared_with', 'all')->orderBy('created_at','desc')->get();

        }

        return view('informations.index', compact('informations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $classes = Mclass::all();
        return view('informations.create', compact('classes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['user_id'] = auth()->user()->id;
        //dd($request->user_id);

        $this->validate(request(), [
            'shared_with' => 'required',
            'file' => 'file|max:2048',
            'description' => 'required',
            'user_id' =>'required'
        ]);

        if ($request->file) {
            $file = $request->file('file');
            $fileName   = time() . $file->getClientOriginalName();

            $destinationPath = 'uploads';
            $file->move($destinationPath,$fileName);
            $request['file'] = $fileName;
        }

        Information::create($request->input());

        return redirect()->back()->with('success','Information envoyé avec succes');
        //dd($request);
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
        $information = Information::find($id);
        
        $information->delete();

        return redirect()->back()->with('success','Information supprimer avec succes');

    }
}
