@extends('layouts.app')

@section('title', 'Liste des matières')
@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Liste des Matières </h3>
                        </div>
                        <div class="card-body">

                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Matières</th>
                                        <th>UE</th>
                                        <th>Professeur</th>
                                        <th>Syllabus </th>
                                        <th>Note des controls continus </th>
                                        <th>Note d'examens</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($courses as $course)
                                        <tr>
                                            <td> {{ $course->matiere->name }} </td>
                                            <td title="{{ $course->matiere->ue->name }}"> {{ $course->matiere->ue->code }}
                                            </td>
                                            <td>
                                                @foreach ($course->matiere->teachers as $teacher)
                                                    {{ $teacher->name }}&nbsp;
                                                @endforeach

                                            </td>
                                            @if ($course->syllabus)
                                                <td><a href="{{ asset('uploads/' . $course->syllabus) }}" target="_blank">
                                                        {{ $course->syllabus }}</a></td>
                                            @else
                                                <td></td>
                                            @endif

                                            <td>
                                                @if (count($course['matiere']['evaluation']))
                                                    {{ $course['matiere']['evaluation'][0]['controle'] }}
                                                @endif
                                            </td>
                                            <td>
                                                @if (count($course['matiere']['evaluation']))
                                                    {{ $course['matiere']['evaluation'][0]['examen'] }}
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Matières</th>
                                        <th>UE</th>
                                        <th>Professeur</th>
                                        <th>Syllabus </th>
                                        <th>Notes Compositions </th>
                                        <th>Notes Examens</th>
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
