@extends('layouts.app')

@section('title', 'modifié une classe')
@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-bold text-uppercase ">Mise à jour des matières</h3>

                            <h3 class="card-title float-right bold text-bold text-uppercase"> {{ $classe->name }} </h3>
                        </div>
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data"
                                action="{{ route('classe.update', $classMatiere->id) }}">
                                @csrf
                                @method('PUT') <!-- Utilisation de la méthode PUT pour l'update -->
                                <input type="hidden" name="mclass_id" value="{{ $classe->id }}">
                                <div class="modal-body">
                                    <div class="card-body">
                                        @php
                                            $totalMatiereNonAffectees = 0;
                                        @endphp

                                        <div class="form-group">
                                            <label>Choisir la matière</label>
                                            <select required name="matiere_id" class="custom-select select2">
                                                <option value="{{ $classMatiere->matiere->id }}">{{ $classMatiere->matiere->name }}</option>
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
                                            <input type="number" max="30" required class="form-control"
                                                id="credit_number" name="max_note"
                                                value="{{ old('max_note', $classMatiere->max_note ?? '') }}">
                                        </div>

                                        <div class="form-group">
                                            <label>Nombre de crédit</label>
                                            <input type="number" required class="form-control" step="0.01"
                                                id="credit_number" name="credit_number"
                                                value="{{ old('credit_number', $classMatiere->credit_number ?? '') }}">
                                        </div>

                                        <label for="exampleInputFile">Charger le Syllabus (pdf, PDF)</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="syllabus" class="custom-file-input"
                                                    id="exampleInputFile">
                                                <label class="custom-file-label" for="exampleInputFile">Choisir le
                                                    fichier</label>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label for="inputPhone3">Proffesseur</label>

                                            <select required name="teacher_id" class="custom-select select2">
                                                @if ($classMatiere->teacher)
                                                    <option value=" {{ $classMatiere->teacher->id }} ">
                                                        {{ $classMatiere->teacher->firstname }}
                                                       {{ $classMatiere->teacher->name }}
                                                    </option>
                                                @else
                                                    <option value="">Choisir un Proffesseur</option>
                                                @endif

                                                @foreach ($teachers as $teacher)
                                                    <option value="{{ $teacher->id }}">
                                                        {{ $teacher->firstname }}
                                                        {{ $teacher->name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                        </div>

                                    </div>


                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-info float-right">Enregistrer les
                                modifications</button>
                        </div>
                        </form>
                    </div>


                </div>

            </div>
        </div>
        </div>
    </section>

@stop
