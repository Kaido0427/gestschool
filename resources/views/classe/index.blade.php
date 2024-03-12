@extends('layouts.app')
@section('title', 'Gestion des classes')
@section('content')


    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Liste des classes </h3>
                            @if (auth()->user()->type == 'admin')
                                <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                                    data-target="#add-classe"> Ajouter </button>
                            @elseif (auth()->user()->type == 'personal')
                                @foreach ($roles as $role)
                                    @if ($role->slug == 'create_mclasses')
                                        <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                                            data-target="#add-classe"> Ajouter </button>
                                    @endif
                                @endforeach
                            @endif

                            <div class="modal fade" id="add-classe" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Enregistré une classe</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <form method="POST" action="{{ route('classes.store') }}">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label>Choissir la filière</label>
                                                        <select required name="sector_id" class="custom-select select2">
                                                            <option value="">Choissir une filière</option>
                                                            @foreach ($sectors as $sector)
                                                                <option value="{{ $sector->id }}"
                                                                    @selected(old('sector') == $sector)>
                                                                    {{ $sector->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                    <div class="form-group">
                                                        <label>Choissir le niveau d'étude</label>
                                                        <select name="level_id" required class="custom-select select2">
                                                            <option value="">Choissir un niveau d'étude</option>
                                                            @foreach ($levels as $level)
                                                                <option value="{{ $level->id }}"
                                                                    @selected(old('level') == $level)>
                                                                    {{ $level->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>

                                                    </div>

                                                </div>

                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Fermer</button>
                                                <button type="submit" class="btn btn-primary">Enregister</button>

                                            </div>
                                        </form>

                                    </div>
                                </div>
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
                                        <th>Nom de classe</th>
                                        <th>Filière</th>
                                        <th>Niveau</th>
                                        <th>Programme</th>
                                        <th>Nombre d'étudiants</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($classes as $classe)
                                        <tr>
                                            <td>{{ $classe['name'] }}</td>
                                            <td> {{ $classe['sector']['code'] }}</td>
                                            <td> {{ $classe['level']['code'] }}</td>

                                            <td>
                                                @if ($classe->time_usage)
                                                    <a href="{{ asset('uploads/' . $classe->time_usage) }}"
                                                        target="_blank">{{ $classe->time_usage }}</a>
                                                @else
                                                @endif

                                            </td>
                                            <td>{{ count($classe->students) }}</td>
                                            <td>
                                                <div class="tools">
                                                    @if (auth()->user()->type == 'admin')
                                                        <button type="button" class="btn btn-info  btn-xs"
                                                            title="Gérer les matière"> <a style="color: white;"
                                                                href="classe/{{ $classe->id }}/matieres"
                                                                data-id="{{ $classe->id }}"><i
                                                                    class="fas fa-book "></i></a>
                                                        </button>
                                                        <button type="button" class="btn btn-info  btn-xs"
                                                            title="Voir la liste des étudiants"> <a style="color: white;"
                                                                href="classe/{{ $classe->id }}/students"
                                                                data-id="{{ $classe->id }}"><i
                                                                    class="ion ion-ios-people-outline"></i></a>
                                                        </button>
                                                        <button title="Ajouter Emploi du temps "type="button"
                                                            class="btn bg-gradient-secondary btn-xs">
                                                            <a href="classe/{{ $classe->id }}/add-time-usage"
                                                                style="color: white;">
                                                                <i class="fas fa-plus "></i>
                                                            </a>
                                                        </button>
                                                        <button title="Modifier une classe "type="button"
                                                            class="btn bg-gradient-secondary btn-xs">
                                                            <a href="{{ route('class.edit', ['id' => $classe->id]) }}"
                                                                style="color: white;">
                                                                <i class="fas fa-edit "></i>
                                                            </a>
                                                        </button>
                                                    @elseif (auth()->user()->type == 'personal')
                                                        @foreach ($roles as $role)
                                                            @if ($role->slug == 'update_mclasses')
                                                                <button type="button" class="btn btn-info  btn-xs"
                                                                    title="Gérer les matière"> <a style="color: white;"
                                                                        href="classe/{{ $classe->id }}/matieres"
                                                                        data-id="{{ $classe->id }}"><i
                                                                            class="fas fa-book "></i></a> </button>
                                                                <button type="button" class="btn btn-info  btn-xs"
                                                                    title="Voir la liste des étudiants"> <a
                                                                        style="color: white;"
                                                                        href="classe/{{ $classe->id }}/students"
                                                                        data-id="{{ $classe->id }}"><i
                                                                            class="ion ion-ios-people-outline"></i></a>
                                                                </button>
                                                                <button title="Ajouter Emploi du temps "type="button"
                                                                    class="btn bg-gradient-secondary btn-xs">
                                                                    <a href="classe/{{ $classe->id }}/add-time-usage"
                                                                        style="color: white;">
                                                                        <i class="fas fa-plus "></i>

                                                                    </a>

                                                                </button>
                                                                <button title="Modifier une classe "type="button"
                                                                    class="btn bg-gradient-secondary btn-xs">
                                                                    <a href="classe/{{ $classe->id }}/edit"
                                                                        style="color: white;">
                                                                        <i class="fas fa-edit "></i>

                                                                    </a>

                                                                </button>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Nom de classe</th>
                                        <th>Filière</th>
                                        <th>Niveau</th>
                                        <th>Programme</th>
                                        <th>Nombre d'étudiants</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>


                        <div class="modal fade" id="editclasse_modal" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Modifier une classe </h4>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close"><span aria-hidden="true">×</span></button>
                                    </div>
                                    @if (count($classes))
                                        <form method="POST" action="classe/{{ $classe->id }}/add-time-usage">
                                            @csrf
                                            @method('PATCH')

                                            <div class="modal-body">
                                                <div class="card-body">

                                                </div>

                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Fermer</button>
                                                <button type="submit" class="btn btn-primary">Enregister</button>

                                            </div>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@stop
