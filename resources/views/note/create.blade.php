@extends('layouts.app')

@section('title', 'Gestion des notes')
@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title ">{{ $classe->name}}</h3>

                            <h3 class="card-title float-right"> {{ $user['name'].' ' .$user['firstname']}}</h3>
                        </div>
                        <div class="card-header">
                            <h3 class="card-title ">Matiere</h3>

                            <h3 class="card-title float-right text-danger text-uppercase"> {{ $mymatiere['name']}}</h3>
                        </div>
                    

                        <div class="card-body">
                            <form class="form-horizontal" method="post" action="{{ route('note.store') }}">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">Note</label>
                                        <div class="col-sm-10">
                                        <input type="hidden" required  name="matiere_id" value="{{$classMatiere->matiere_id}}">
                                        <input type="hidden" required  name="classe_id" value="{{$classe->id}}">
                                        <input type="hidden" required  name="user_id" value="{{ $user['id']}}">
                                       
                                        <input type="hidden" required  name="cours_id" value="{{ $classMatiere->id}}">


                                        <input type="number" required class="form-control" id="inputName" min=0 max={{$classMatiere['max_note']}} step="0.01" name="note" placeholder="Note sur {{ $classMatiere['max_note'] }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">Type de Note</label>
                                        <div class="col-sm-10">
                                            
                                            <select name="type" class="custom-select">
                                                <option value="examen">Examen</option>
                                                <option value="composition">Control Continue</option>
                                            </select>
                                        </div>
                                    </div>

                      
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-info float-right">Enregistrer</button>
                                </div>
                            </form>
                        </div>
                    </div>


                    <div class="card-body">

                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                
                                <p>{{ $message }}</p>
                            </div>
                        @endif
                    

                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Control continu (40%)</th>
                                    <th>Examen (60%)</th>
                                    <th>Note Finale</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <tr>
                                        <td>
                                            @if ($note)
                                            {{$note['controle']}}
                                                
                                            @endif
                                        </td>
                                        <td> 
                                            @if ($note)
                                            {{$note['examen']}}
                                                
                                            @endif

                                        </td>
                                        <td>
                                            @if ($note)
                                                {{ $note['controle'] + $note['examen']}}                                                
                                            @endif
                                        </td>
                                    </tr>

                            
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Control continu</th>
                                <th>Examen</th>
                                <th>Note Finale</th>
                            </tr>
                            </tfoot>
                        </table>

                    </div>
            
                </div>
            </div>
        </div>
    </section>


@stop