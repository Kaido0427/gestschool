<?php

namespace App\Http\Controllers;

use App\Models\DateImportant;
use Illuminate\Http\Request;

class DateImportantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = DateImportant::all();

        return view('date-important.index', compact('events'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('date-important.create');
        
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
            'date' => 'required',
            'event' => 'required',
        ]);


        DateImportant::create($request->input());

        return redirect()->back()->with('success','Evènement enregistré avec succes');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DateImportant  $dateImportant
     * @return \Illuminate\Http\Response
     */
    public function show(DateImportant $dateImportant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DateImportant  $dateImportant
     * @return \Illuminate\Http\Response
     */
    public function edit(DateImportant $dateImportant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DateImportant  $dateImportant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DateImportant $dateImportant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DateImportant  $dateImportant
     * @return \Illuminate\Http\Response
     */
    public function destroy(DateImportant $dateImportant)
    {
        //
    }
}
