@extends('layouts.app')
@section('title', 'Liste des matières par classe')
@section('content')


    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title text-bold text-uppercase ">Ajout de matieres </h3>

                                <h3 class="card-title float-right bold text-bold text-uppercase"> {{ $classe['name'] }} </h3>
                            </div>
                            <div class="card-body">

                                <form method="POST" enctype="multipart/form-data" action="{{ route('classe.matiere') }}">
                                    @csrf
                                    <input type="hidden" name="classe_id" value="{{ $classe->id }}">
                                    <div class="modal-body">
                                        <div class="card-body">

                                            @php
                                                $totalMatiereNonAffectees = 0;
                                            @endphp

                                            <div class="form-group">
                                                <label>Choisir la matière</label>
                                                <select required name="matiere_id" class="custom-select select2">
                                                    <option value="">Choisir une matière</option>
                                                    @foreach ($semestres as $semestre)
                                                        @if ($semestre->matieres->isNotEmpty())
                                                            <optgroup label="{{ $semestre->name }}">
                                                                @php
                                                                    $matieresNonAffectees = $semestre->matieres->reject(function ($matiere) use ($classe) {
                                                                        return $classe->matieres->contains($matiere->id);
                                                                    });
                                                                @endphp

                                                                @foreach ($matieresNonAffectees as $matiere)
                                                                    <option value="{{ $matiere->id }}"
                                                                        {{ old('matiere_id') == $matiere->id ? 'selected' : '' }}>
                                                                        {{ $matiere->name }}
                                                                    </option>
                                                                @endforeach
                                                            </optgroup>
                                                        @else
                                                            @php
                                                                $totalMatiereNonAffectees++;
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>




                                            <div class="form-group">
                                                <label>Noté sur :</label>

                                                <input type="number" max=30 required class="form-control"
                                                    id="credit_number" name="max_note">

                                            </div>
                                            <div class="form-group">
                                                <label>Nombre de crédit</label>

                                                <input type="number" required class="form-control" step="0.01"
                                                    id="credit_number" name="credit_number">

                                            </div>

                                            <label for="exampleInputFile">Charger le Syllabus (pdf, PDF)</label>
                                            <div class="input-group">
                                                <div class="custom-file">

                                                    <input type="file" name="syllabus" class="custom-file-input"
                                                        id="exampleInputFile">
                                                    <label class="custom-file-label" for="exampleInputFile">Choisir
                                                        le fichier</label>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="form-group">
                                                <label for="inputPhone3">Proffesseur</label>

                                                <select required name="teacher_id" class="custom-select select2">
                                                    <option value="">Choisir Un Professeur à affecter à cette
                                                        classe
                                                    </option>
                                                    @foreach ($teachers as $teacher)
                                                        <option value="{{ $teacher->id }}">
                                                            {{ $teacher->name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                            </div>

                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-info float-right">Enregister</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <h1 class="card-title text-bold text-uppercase text-center text-danger text-decoration-underline">
                            Liste des matières de {{ $classe->name }}
                        </h1>
                        <div class="card-body">
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success alert-dismissible">
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

                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Matière</th>
                                        <th>UE</th>
                                        <th>Semestre</th>
                                        <th>Professeur</th>
                                        <th>Crédit</th>
                                        <th>Noté sur</th>
                                        <th>Syllabus</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($classeWithMatieres as $classMatiere)
                                        <tr>
                                            <td class="text-center">{{ $classMatiere->matiere->name }}</td>
                                            <td class="text-center">{{ $classMatiere->matiere->ue->name }}</td>
                                            <td class="text-center">
                                                @foreach ($classMatiere->matiere->semestres as $semestre)
                                                    @if ($semestre->level_id == $classe->level_id && $classe->matieres->contains($classMatiere->matiere->id))
                                                        {{ $semestre->name }}
                                                        <strong>({{ $semestre->level->code }})</strong>
                                                    @endif
                                                @endforeach

                                            </td>
                                            <td class="text-center">
                                                @if ($classMatiere->teacher)
                                                    {{ $classMatiere->teacher->firstname }}
                                                    {{ $classMatiere->teacher->name }}
                                                @else
                                                    Aucun professeur affecté
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $classMatiere->credit_number }}</td>
                                            <td class="text-center">{{ $classMatiere->max_note }}</td>
                                            <td>
                                                @if ($classMatiere->syllabus)
                                                    <a href="{{ asset('uploads/' . $classMatiere->syllabus) }}"
                                                        target="_blank">Syllabus</a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                {{--
                                                <button
                                                    title="Supprimer {{ $classMatiere->matiere->name }} de {{ $classe->name }}"
                                                    type="button" class="btn bg-danger btn-xs">
                                                    <a href="#"
                                                        onclick="$('#delete_matiere_in_class_form').attr('action','{{ url('matiere/' . $classMatiere->matiere->id . '/in-classe/' . $classe->id) }}'); $('#delete_matiere_in_class').modal()"
                                                        class="list-icons-item text-danger-800" data-popup="tooltip"
                                                        title="" data-container="body"
                                                        data-original-title="Désactiver">
                                                        <i class="fas fa-trash bg-danger"></i>
                                                    </a>
                                                </button>
                                                --}}
                                                <button
                                                    title="Modifier {{ $classMatiere->matiere->name }} de {{ $classe->name }}"
                                                    type="button" class="btn bg-warning btn-xs">
                                                    <a href="{{ route('classMat.edit', ['id' => $classMatiere->id]) }}"
                                                        class="list-icons-item text-warning-800" data-popup="tooltip"
                                                        title="" data-container="body" data-original-title="Modifier">
                                                        <i class="fas fa-edit bg-warning"></i>
                                                    </a>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Matière</th>
                                        <th>UE</th>
                                        <th>Semestre</th>
                                        <th>Professeur</th>
                                        <th>Crédit</th>
                                        <th>Noté sur</th>
                                        <th>Syllabus</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
    </section>

    @include('includes._activate_modal')


@stop
