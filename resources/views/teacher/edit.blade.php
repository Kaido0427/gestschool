@extends('layouts.app')

@section('title', 'Modifier les données d\'un professeur')
@section('title_p', 'Gestion des professeur')
@section('parent_a', '/teachers')
@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Modifier les données d'un professeur</h3>
                            <a class="btn btn-primary float-right" href="{{ route('teachers.index') }}">Voir la liste</a>

                        </div>
                        <div class="card-body">
                            @if ($message = Session::get('error'))
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                                    <p>{{ $message }}</p>
                                </div>
                            @endif
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                                    <p>{{ $message }}</p>
                                </div>
                            @endif
                            <form class="form-horizontal" method="post" action="/teachers/{{ $teacher->id }}">
                                @method('PATCH')
                                @csrf
                                <div class="card-body">
                                    @if ($message = Session::get('error'))
                                        <div class="alert alert-danger alert-dismissible">
                                            <button type="button" class="close" data-dismiss="alert"
                                                aria-hidden="true">×</button>

                                            <p>{{ $message }}</p>
                                        </div>
                                    @endif

                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">Nom</label>
                                        <div class="col-sm-10">
                                            <input type="text" required class="form-control" id="inputName"
                                                name="name" value="{{ $teacher->name }}" placeholder="Nom">
                                        </div>

                                    </div>
                                    <div class="form-group row">

                                        <label for="inputFirstName" class="col-sm-2 col-form-label">Prénom(s)</label>
                                        <div class="col-sm-10">
                                            <input type="text" required class="form-control" id="inputFirstName"
                                                name="firstname" value="{{ $teacher->firstname }}" placeholder="Prénom(s)">

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputAdresse" class="col-sm-2 col-form-label">Adresse</label>
                                        <div class="col-sm-10">
                                            <input type="text" required class="form-control" id="inputAdresse"
                                                name="address" value="{{ $teacher->address }}"
                                                placeholder="Adresse complète">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-5">
                                            <input type="email" required class="form-control" id="inputEmail3"
                                                name="email" value="{{ $teacher->email }}" placeholder="Email">
                                        </div>
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Genre</label>
                                        <div class="col-sm-3">
                                            <input type="text" required class="form-control" id="inputEmail3"
                                                name="gender" value="{{ $teacher->gender }}" placeholder="genre">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPhone3" class="col-sm-2 col-form-label">Téléphone</label>
                                        <div class="col-sm-10">
                                            <input type="Phone" required class="form-control" id="inputPhone3"
                                                name="phone" value="{{ $teacher->phone }}" placeholder="Phone">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-info float-right">Modifier</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

@stop
