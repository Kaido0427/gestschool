@extends('layouts.app')

@section('title', 'Syllabus')
@section('title_p', 'Gestion des classes')
@section('parent_a', '/teachers')
@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Ajouter syllabus</h3>
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
                            <form class="form-horizontal" method="post"
                                action="{{ route('addSyllabus', ['classe' => $myClass->id, 'id' => $myClass->matiere_id]) }}" enctype="multipart/form-data">
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
                                        <label for="inputName" class="col-sm col-form-label">Charger le Syllabus
                                            (.PDF)</label>

                                        <div class="custom-file">
                                            <input type="file" name="syllabus" class="custom-file-input"
                                                id="exampleInputFile">
                                            <label class="custom-file-label" for="exampleInputFile">Choisir le
                                                fichier</label>
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-info float-right">Ajouter</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

@stop
