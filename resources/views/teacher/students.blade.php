@extends('layouts.app')

@section('title', 'liste des étudiants')
@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Liste de mes étudiants</h3>
                        </div>
                        <div class="card-body">

                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Noms</th>
                                        <th>Prénoms </th>
                                        <th>Téléphones </th>
                                        <th>Controle continue </th>
                                        <th>Examen </th>
                                        <th>Note finale </th>
                                        <th>Actions </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($students as $student)
                                        @if (($cours->night === 1 && $student->student->night === 1) || ($cours->night === 0 && $student->student->night === 0))
                                            <tr>
                                                <td> {{ $student->student->name }} </td>
                                                <td> {{ $student->student->firstname }} </td>
                                                <td> {{ $student->student->phone }} </td>

                                                <td>
                                                    @if (count($student->student->evaluation))
                                                        {{ $student->student->evaluation[0]['controle'] }}
                                                    @endif
                                                </td>

                                                <td>
                                                    @if (count($student->student->evaluation))
                                                        {{ $student->student->evaluation[0]['examen'] }}
                                                    @endif
                                                </td>

                                                <td>
                                                    @if (count($student->student->evaluation))
                                                        {{ $student->student->evaluation[0]['examen'] + $student->student->evaluation[0]['controle'] }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <button type="button" class="btn bg-gradient-secondary btn-xs"
                                                        title="Ajouter une note à: {{ $student->student->name . ' ' . $student->student->firstname }}">

                                                        <a style="color: white;"
                                                            href="/classe/{{ $student->mclass_id }}/matiere/{{ $matiere }}/student/{{ $student->student['matricule'] }}"
                                                            data-id="">

                                                            <i class="fas fa-plus"></i>
                                                        </a>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <th>Noms</th>
                                        <th>Prénoms </th>
                                        <th>Téléphones </th>
                                        <th>Compositions </th>
                                        <th>Examens </th>
                                        <th>Note finale </th>
                                        <th>Action </th>
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
