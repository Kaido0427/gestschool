@extends('layouts.app')

@section('title', 'Les dates importantes')
@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title ">Enregistrement des dates importantes</h3>
                            <a class="btn btn-info float-right" href="{{ route('dateimportants.index') }}">Voir +</a>

                        </div>
                        <div class="card-body">
                            <div>
                                @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true">×</button>

                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @if ($message = Session::get('success'))
                                    <div class="alert alert-success alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true">×</button>

                                        <p>{{ $message }}</p>
                                    </div>
                                @endif
                            </div>
                            <form class="form-horizontal" method="post" action="{{ route('dateimportants.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">


                                    <div class="form-group row">
                                        <label for="InputFile" class="col-sm-2 col-form-label"> Date:</label>
                                        <div class="col-sm-10">
                                        <input type="text" name="date" class="form-control" placeholder="Lundi 01 Avril 1993">

                                           
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">Description :</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" rows="3" name="event" placeholder="Description"></textarea>

                                        </div>
                                    </div>
                                    

                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-info float-right">Envoyé</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

@stop
