@extends('layouts.app')

@section('title', 'Notes')
@section('content')


    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Notes </h3>
                        </div>
 

                        <div class="card-header">

                            <ul class="nav nav-tabs" id="semesterTabs">
                                <li class="nav-item">
                                    <a class="nav-link active" id="semester1-tab" data-toggle="tab"
                                        href="#semester1">Semestre 1</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="semester2-tab" data-toggle="tab" href="#semester2">Semestre
                                        2</a>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content mt-2">
                            <div class="tab-pane fade show active" id="semester1">
                                <div class="card-body">

                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Matières</th>
                                                <th>Controls continues </th>
                                                <th>Examens</th>
                                                <th>Note finale</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($courses as $course)
                                                @if ($course->matiere && $course->matiere->ue->semestre == $semestre)
                                                    <tr>
                                                        <td> {{ $course->matiere->name }} </td>

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
                                                        <td>
                                                            @if (count($course['matiere']['evaluation']))
                                                                {{ $course['matiere']['evaluation'][0]['examen'] + $course['matiere']['evaluation'][0]['controle'] }}
                                                            @endif
                                                        </td>

                                                    </tr>
                                                @endif
                                            @endforeach

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Matières</th>
                                                <th>Controls continues </th>
                                                <th>Examens</th>
                                                <th>Note finale</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                {{-- Afficher les données du semestre 1 --}}
                                {{-- Utiliser la variable $data pour afficher les données --}}
                            </div>

                            <div class="tab-pane fade " id="semester2">
                                <div class="card-body">

                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Matières</th>
                                                <th>Controls continues </th>
                                                <th>Examens</th>
                                                <th>Note finale</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($courses as $course)
                                                @if ($course->matiere && $course->matiere->ue->semestre == $semestre)
                                                    <tr>
                                                        <td> {{ $course->matiere->name }} </td>

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
                                                        <td>
                                                            @if (count($course['matiere']['evaluation']))
                                                                {{ $course['matiere']['evaluation'][0]['examen'] + $course['matiere']['evaluation'][0]['controle'] }}
                                                            @endif
                                                        </td>

                                                    </tr>
                                                @endif
                                            @endforeach

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Matières</th>
                                                <th>Controls continues </th>
                                                <th>Examens</th>
                                                <th>Note finale</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                {{-- Afficher les données du semestre 1 --}}
                                {{-- Utiliser la variable $data pour afficher les données --}}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#semesterTabs a').on('click', function(e) {
                e.preventDefault()
                $(this).tab('show')
            })
        });
    </script>
@endpush
