@extends('layouts.app')

@section('title', 'Enregistrement des étudiants')
@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Enregistrer un étudiant</h3>
                            <a class="btn btn-primary float-right" href="{{ route('students.index') }}">Voir la liste</a>

                        </div>
                        <div class="panel-body">
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                                    {{ session('error') }}
                                </div>
                            @endif
                            @if (session('success'))
                                <div class="alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                                    {{ session('success') }}
                                </div>
                            @endif
                            @if ($errors)
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true">×</button>

                                        {{ $error }}
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal" method="post" action="{{ route('students.store') }}">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">N° matricule</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="inputEmailh3" name="matricule"
                                                placeholder="N° matricule">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">Nom</label>
                                        <div class="col-sm-10">
                                            <input type="text" required class="form-control" id="inputName"
                                                name="name" placeholder="Nom">
                                        </div>

                                    </div>
                                    <div class="form-group row">

                                        <label for="inputFirstName" class="col-sm-2 col-form-label">Prénom(s)</label>
                                        <div class="col-sm-10">
                                            <input type="text" required class="form-control" id="inputFirstName"
                                                name="firstname" placeholder="Prénom(s)">

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputAdresse" class="col-sm-2 col-form-label">Adresse</label>
                                        <div class="col-sm-10">
                                            <input type="text" required class="form-control" id="inputAdresse"
                                                name="address" placeholder="Adresse complète">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-5">
                                            <input type="email" required class="form-control" id="inputEmail3"
                                                name="email" placeholder="Email">
                                        </div>
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Genre</label>
                                        <div class="col-sm-3">
                                            <input type="text" required class="form-control" id="inputEmail3"
                                                name="gender" placeholder="genre">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPhone3" class="col-sm-2 col-form-label">Téléphone</label>
                                        <div class="col-sm-10">
                                            <input type="Phone" required class="form-control" id="inputPhone3"
                                                name="phone" placeholder="Phone">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputbirthday3" class="col-sm-2 col-form-label">Date de
                                            naissance</label>
                                        <div class="col-sm-10">
                                            <input type="date" required class="form-control" id="inputPhone3"
                                                name="birth_day" placeholder="Date de naissance">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputbirthplace3" class="col-sm-2 col-form-label">Lieu de
                                            naissance</label>
                                        <div class="col-sm-10">
                                            <input type="text" required class="form-control" id="inputPhone3"
                                                name="birth_place" placeholder="Lieu de naissance">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputbirthplace3" class="col-sm-2 col-form-label">Nationalité</label>
                                        <div class="col-sm-10">
                                            <input type="text" required class="form-control" id="inputPhone3"
                                                name="nationality" placeholder="Nationalité">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">classe</label>
                                        <div class="col-sm-10">
                                            <select name="mclasse_id" required class="custom-select select2">*
                                                <option value="">Choisir la classe</label>
                                                    @foreach ($classes as $classe)
                                                <option value="{{ $classe->id }}" @selected(old('classe') == $classe)>
                                                    {{ $classe->name }}
                                                </option>
                                                @endforeach
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
                </div>
            </div>
        </div>
    </section>

@stop
