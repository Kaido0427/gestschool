@extends('layouts.app')

@section('title', 'Mes classes')
@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                            <p>{{ $message }}</p>
                        </div>
                    @endif
                    @if ($message = Session::get('warning'))
                        <div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                            <p>{{ $message }}</p>
                        </div>
                    @endif
                    @if ($message = Session::get('info'))
                        <div class="alert alert-info alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                            <p>{{ $message }}</p>
                        </div>
                    @endif
                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                            <p>{{ $message }}</p>
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Liste de mes Classes</h3>
                        </div>
                        <div class="card-body">

                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nom de la classe</th>
                                        <th>Matiere </th>
                                        <th>Syllabus </th>
                                        <th>Action </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @php
                                        $previousClass = null;
                                    @endphp

                                    @foreach ($classByTeacher as $index => $classe)
                                        <tr>
                                            @if ($classe->classe->name !== $previousClass)
                                                <td rowspan="{{ $classByTeacher->where('classe.name', $classe->classe->name)->count() }}"
                                                    style="vertical-align: middle; text-align: center;">
                                                    {{ $classe->classe->name }}
                                                </td>
                                                @php
                                                    $previousClass = $classe->classe->name;
                                                @endphp
                                            @endif
                                            <td style="vertical-align: middle;"> {{ $classe->matiere->name }} </td>
                                            <td style="vertical-align: middle;">
                                                @if ($classe->syllabus)
                                                    <a href="{{ asset('/uploads/' . $classe->syllabus) }}"
                                                        target="_blank">Syllabus</a>
                                                @endif
                                            </td>
                                            @if ($index % $classByTeacher->where('classe.name', $classe->classe->name)->count() == 0)
                                                <td rowspan="{{ $classByTeacher->where('classe.name', $classe->classe->name)->count() }}"
                                                    style="vertical-align: middle; text-align: center;">
                                                    <button type="button" class="btn btn-info btn-xs"
                                                        title="Voir la liste des étudiants"
                                                        onclick="window.location.href='/teacher/{{ Auth::user()->id }}/matiere/{{ $classe->matiere->id }}/classe/{{ $classe->classe->id }}/students'"
                                                        data-id="{{ $classe->id }}">
                                                        <i class="ion ion-ios-people-outline"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-warning btn-xs"
                                                        title="Ajouter le syllabus"
                                                        onclick="window.location.href='/editSyllabus/classe/{{ $classe->id }}'"
                                                        data-id="{{ $classe->id }}">

                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor" class="bi bi-book"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z" />
                                                        </svg>
                                                    </button>

                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach




                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Nom de la classe</th>
                                        <th>Matiere </th>
                                        <th>Syllabus </th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>


@stop
