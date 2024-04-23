@extends('layouts.app')

@section('title', 'Modifier les données d\'un étudiant')
@section('title_p', 'Gestion des étudiants')
@section('parent_a', '/students')
@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Modifier les données d'un étudiant</h3>
                            <a class="btn btn-primary float-right" href="{{ route('students.index') }}">Voir la liste</a>

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
                            <form class="form-horizontal" method="post" action="/students/{{ $student->id }}">
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
                                        <label for="inputMat" class="col-sm-2 col-form-label">Matricule</label>
                                        <div class="col-sm-10">
                                            <input type="text" required class="form-control" id="inputMat"
                                                name="matricule" value="{{ $student->matricule }}" placeholder="matricule">
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">Nom</label>
                                        <div class="col-sm-10">
                                            <input type="text" required class="form-control" id="inputName"
                                                name="name" value="{{ $student->name }}" placeholder="Nom">
                                        </div>

                                    </div>
                                    <div class="form-group row">

                                        <label for="inputFirstName" class="col-sm-2 col-form-label">Prénom(s)</label>
                                        <div class="col-sm-10">
                                            <input type="text" required class="form-control" id="inputFirstName"
                                                name="firstname" value="{{ $student->firstname }}" placeholder="Prénom(s)">

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputAdresse" class="col-sm-2 col-form-label">Adresse</label>
                                        <div class="col-sm-10">
                                            <input type="text" required class="form-control" id="inputAdresse"
                                                name="address" value="{{ $student->address }}"
                                                placeholder="Adresse complète">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-5">
                                            <input type="email" required class="form-control" id="inputEmail3"
                                                name="email" value="{{ $student->email }}" placeholder="Email">
                                        </div>
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Genre</label>
                                        <div class="col-sm-3">
                                            <input type="text" required class="form-control" id="inputEmail3"
                                                name="gender" value="{{ $student->gender }}" placeholder="genre">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPhone3" class="col-sm-2 col-form-label">Téléphone</label>
                                        <div class="col-sm-10">
                                            <input type="Phone" required class="form-control" id="inputPhone3"
                                                name="phone" value="{{ $student->phone }}" placeholder="Phone">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputbirthday3" class="col-sm-2 col-form-label">Date de
                                        naissance</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputPhone3" name="birth_day"
                                            value="{{ $student->birth_day }}" placeholder="Date de naissance">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputbirthplace3" class="col-sm-2 col-form-label">Lieu de
                                        naissance</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputPhone3" name="birth_place"
                                            value="{{ $student->birth_place }}" placeholder="Lieu de naissance">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputbirthplace3" class="col-sm-2 col-form-label">Nationalité</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputPhone3" name="nationality"
                                            value="{{ $student->nationality }}" placeholder="Nationalité">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">classe</label>
                                    <div class="col-sm-10">
                                        <select name="mclass_id" required class="custom-select select2">

                                            @foreach ($classes as $classe)
                                                <option value="{{ $classe->id }}" @selected(old('classe') == $classe)>
                                                    {{ $classe->name }}
                                                </option>
                                            @endforeach
                                        </select>
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
