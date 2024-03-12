@extends('layouts.app')

@section('title', 'Partage d\'informations')
@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title ">Envoie d'information</h3>
                            <a class="btn btn-info float-right" href="{{ route('informations.index') }}">Voir +</a>

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
                            <form class="form-horizontal" method="post" action="{{ route('informations.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">Description :</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" rows="3" name="description" placeholder="Description"></textarea>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="shareWith" class="col-sm-2 col-form-label">Patarger avec :</label>
                                        <div class="col-sm-10">

                                            <select name="shared_with" class="custom-select">
                                                <option value="all">Toute l'université </option>
                                                <option value="students">Tous les étudiants</option>
                                                <option value="teachers">Tous les professeurs</option>
                                                <option value="teachers">Les membres d'administration </option>
                                                @foreach ($classes as $classe)
                                                    <option value="{{ $classe->id }}" @selected(old('classe') == $classe)>
                                                        {{ $classe->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="InputFile" class="col-sm-2 col-form-label"> Fichier (pdf):</label>
                                        <div class="col-sm-10">

                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="file" class="custom-file-input"
                                                        id="InputFile">
                                                    <label class="custom-file-label" for="InputFile">Choose
                                                        file</label>
                                                </div>
                                            </div>
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
