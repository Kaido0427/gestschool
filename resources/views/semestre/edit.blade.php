@extends('layouts.app')

@section('title', 'Modifier un semestre')
@section('title_p', 'Gestion des semestres')
@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Modifier un semestre</h3>
                            <a class="btn btn-primary float-right" href="{{ route('semestres.index') }}">Voir la liste</a>

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
                            <form class="form-horizontal" method="post" action="/semestres/{{ $semestre->id }}">
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
                                        <label for="inputMat" class="col-sm-2 col-form-label">Nom du semestre</label>
                                        <div class="col-sm-10">
                                            <input type="text" required class="form-control" id="inputMat"
                                                name="name" value="{{ $semestre->name }}" placeholder="Nom du semestee">
                                        </div>


                                    </div>

                                    <div class="form-group row ">
                                        <label class="col-sm-2 col-form-label">Niveau d'étude</label>
                                        <div class="col-sm-10">
                                            <select required name="level_id" class="custom-select select2">
                                                <option value="{{ $semestre->level->id }}">{{ $semestre->level->name }}
                                                </option>
                                                @foreach ($levels as $level)
                                                    <option value="{{ $level->id }}" @selected(old('level') == $level)>
                                                        {{ $level->name }} @if ($level->code)
                                                            ({{ $level->code }})
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
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
