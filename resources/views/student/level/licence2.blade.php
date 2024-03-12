@extends('layouts.app')

@section('title', 'Notes')
@section('content')


    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Notes <span class="text-danger">({{ $userLevel->mclass->name }})</span>
                            </h3>
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
                                                <th>UE</th>
                                                <th>Controls continues </th>
                                                <th>Examens</th>
                                                <th>Note finale</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($courses->isNotEmpty())
                                                @foreach ($courses as $course)
                                                    @if ($course->matiere && $course->matiere->ue->semestres->contains('name', 'Semestre 3'))
                                                        <tr>
                                                            <td>{{ $course->matiere->name }}</td>
                                                            <td>{{ $course->matiere->ue->name }}</td>

                                                            <td>
                                                                @if ($course->matiere->evaluation->isNotEmpty())
                                                                    {{ $course->matiere->evaluation->first()->controle }}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($course->matiere->evaluation->isNotEmpty())
                                                                    {{ $course->matiere->evaluation->first()->examen }}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($course->matiere->evaluation->isNotEmpty())
                                                                    {{ $course->matiere->evaluation->first()->examen + $course->matiere->evaluation->first()->controle }}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5">
                                                        <p class="text-center text-uppercase text-danger">Données
                                                            inexistantes</p>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>


                                        <tfoot>
                                            <tr>
                                                <th>Matières</th>
                                                <th>UE</th>
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
                                                <th>UE</th>
                                                <th>Controls continues </th>
                                                <th>Examens</th>
                                                <th>Note finale</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($courses->isNotEmpty())
                                                @foreach ($courses as $course)
                                                    @if ($course->matiere && $course->matiere->ue->semestres->contains('name', 'Semestre 4'))
                                                        <tr>
                                                            <td>{{ $course->matiere->name }}</td>
                                                            <td>{{ $course->matiere->ue->name }}</td>

                                                            <td>
                                                                @if ($course->matiere->evaluation->isNotEmpty())
                                                                    {{ $course->matiere->evaluation->first()->controle }}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($course->matiere->evaluation->isNotEmpty())
                                                                    {{ $course->matiere->evaluation->first()->examen }}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($course->matiere->evaluation->isNotEmpty())
                                                                    {{ $course->matiere->evaluation->first()->examen + $course->matiere->evaluation->first()->controle }}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5">
                                                        <p class="text-center text-uppercase text-danger">Données
                                                            inexistantes</p>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>


                                        <tfoot>
                                            <tr>
                                                <th>Matières</th>
                                                <th>UE</th>
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
