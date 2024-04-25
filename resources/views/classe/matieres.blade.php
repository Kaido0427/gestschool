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
                                                                    $matieresNonAffectees = $semestre->matieres->reject(
                                                                        function ($matiere) use ($classeWithMatieres) {
                                                                            $countJour = $classeWithMatieres
                                                                                ->where('matiere_id', $matiere->id)
                                                                                ->where('time', 0)
                                                                                ->count();
                                                                            $countSoir = $classeWithMatieres
                                                                                ->where('matiere_id', $matiere->id)
                                                                                ->where('time', 1)
                                                                                ->count();
                                                                            return $countJour >= 1 && $countSoir >= 1; // Vérifier si la matière a déjà été ajoutée deux fois à la classe (une fois pour "jour" et une fois pour "soir")
                                                                        },
                                                                    );
                                                                @endphp

                                                                @foreach ($matieresNonAffectees as $matiere)
                                                                    @if ($classeWithMatieres->where('matiere_id', $matiere->id)->count() < 2)
                                                                        // Vérifier si la matière a déjà été ajoutée deux
                                                                        fois à la classe (un pour "jour" et un pour "soir")
                                                                        <option value="{{ $matiere->id }}"
                                                                            {{ old('matiere_id') == $matiere->id ? 'selected' : '' }}>
                                                                            {{ $matiere->name }}
                                                                        </option>
                                                                    @endif
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
                                            <td class="text-center">{{ $classMatiere->matiere->name }}
                                                @if (in_array($classe->name, ['MFA1', 'MFA2']))
                                                    <strong id="daynight">

                                                        @if ($classMatiere->night === 1)
                                                            (Soir)
                                                        @else
                                                            (Jour)
                                                        @endif
                                                    </strong>
                                                @endif
                                            </td>
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
                                                @if (in_array($classe->name, ['MFA1', 'MFA2']))
                                                    <form id="MatnightForm">
                                                        @csrf
                                                        <input type="hidden" name="cours_id"
                                                            value="{{ $classMatiere->id }}">
                                                        <button id="MatnightBtn" class="btn btn-primary btn-xs"
                                                            data-state="{{ $classMatiere->night ? 'night' : 'day' }}"
                                                            data-cours-id="{{ $classMatiere->id }}">
                                                            @if ($classMatiere->night)
                                                                <i class="fas fa-moon"></i>
                                                            @else
                                                                <i class="fas fa-sun"></i>
                                                            @endif
                                                        </button>
                                                    </form>
                                                @endif

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
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            console.log('DOM chargé');
            console.log($('#MatnightBtn').length); // Vérifie si le sélecteur trouve le bouton

            // Utilisez la fonction .on() pour attacher le gestionnaire d'événements click
            $(document).on('click', '#MatnightBtn', function() {
                console.log('Bouton cliqué');
                var $button = $(this);

                // Désactiver le bouton pour éviter les clics multiples 
                $button.prop('disabled', true);

                // Changer l'icône par l'icône de chargement
                $button.html('<i class="fas fa-spinner fa-spin"></i>');

                // Récupérer l'ID de l'utilisateur à partir de l'attribut data-user-id
                var matId = $button.data('cours-id');

                // Ajouter le jeton CSRF aux données de la requête
                var token = $('meta[name="csrf-token"]').attr('content');
                console.log('ID de cours :', matId);

                // Envoyer une requête AJAX pour basculer la valeur de 'night'
                $.ajax({
                    url: '{{ route('matieres.night') }}',
                    method: 'POST',
                    data: {
                        _token: token,
                        cours_id: matId
                    },
                    success: function(response) {
                        console.log('Requête AJAX réussie :', response);

                        // Mettre à jour l'icône et l'état en fonction de la réponse du serveur
                        var icon = response.matiere_night ? '<i class="fas fa-moon"></i>' :
                            '<i class="fas fa-sun"></i>';
                        var state = response.matiere_night ? 'night' : 'day';
                        var content = response.matiere_night ? '(Soir)' : '(Jour)';
                        $button.html(icon);
                        $button.attr('data-state', state);

                        var content = response.matiere_night ? '(Soir)' : '(Jour)';
                        $button.closest('tr').find('#daynight').text(content);

                        // Réactiver le bouton après 1 seconde
                        setTimeout(function() {
                            $button.prop('disabled', false);
                        }, 500);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Une erreur est survenue lors de la requête AJAX :',
                            textStatus, errorThrown);

                        // Réactiver le bouton après 1 seconde
                        setTimeout(function() {
                            $button.prop('disabled', false);
                        }, 1000);
                    }
                });
            });
        });
    </script>

@stop
