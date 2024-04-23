@extends('layouts.app')

@section('title', 'Gestion des Matieres')
@section('content')


    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Liste des Matieres</h3>
                            @if (auth()->user()->type == 'admin')
                                <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                                    data-target="#add-matiere">
                                    Ajouter
                                </button>
                            @elseif(auth()->user()->type == 'personal')
                                @foreach ($roles as $role)
                                    @if ($role->slug == 'create_matieres')
                                        <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                                            data-target="#add-matiere">
                                            Ajouter
                                        </button>
                                    @endif
                                @endforeach
                            @endif

                            <div class="modal fade" id="add-matiere" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Ajouter une matière</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <form method="POST" action="{{ route('matieres.store') }}">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label>Choisir l'UE</label>
                                                        <select required name="ue_id" id="ue_id"
                                                            class="custom-select select2">
                                                            <option value="">Choisir un UE</option>
                                                            @foreach ($ues as $ue)
                                                                <option value="{{ $ue->id }}"
                                                                    {{ old('ue_id') == $ue->id ? 'selected' : '' }}>
                                                                    {{ $ue->name }}
                                                                    @if ($ue->code)
                                                                        ({{ $ue->code }})
                                                                    @endif
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Choisir le(s) semestre(s)</label>
                                                        <div id="semestres_container">

                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="name">Nom de la matière</label>
                                                        <input type="text" required class="form-control" id="name"
                                                            name="name" placeholder="Exemple: Théologie">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Fermer</button>
                                                <button type="submit" class="btn btn-primary">Enregistrer</button>
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


                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Libellés</th>
                                        <th>Unité d'enseignement</th>
                                        <th>semestre</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($matieres as $matiere)
                                        <tr>
                                            <td style="text-align: center;">{{ $matiere->name }}</td>

                                            <td style="text-align: center;">
                                                @if ($matiere->ue)
                                                    {{ $matiere->ue->name }}
                                                @else
                                                    ---
                                                @endif
                                            </td>
                                            <td style="text-align: center;">
                                                @if ($matiere->semestres->isNotEmpty())
                                                    @foreach ($matiere->semestres as $index => $semestre)
                                                        {{ $semestre->name }}
                                                        <strong>({{ $semestre->level->code }})</strong>
                                                        @if ($index < $matiere->semestres->count() - 1)
                                                            <br>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    aucun semestre n'est affecté à cette matière
                                                @endif
                                            </td>
                                            <td style="text-align: center;">
                                                <div class="tools">
                                                    @if (auth()->user()->type == 'admin')
                                                        <a href="#" onclick="editMatiere(this)"
                                                            data-target='#editMatiere_modal' data-toggle="modal"
                                                            data-matiere ="{{ $matiere }}"><i
                                                                class="fas fa-edit "></i></a>


                                                    
                                                    @else
                                                        @foreach ($roles as $role)
                                                            @if ($role->slug == 'update_matieres')
                                                                <a href="" onclick="editMatiere(this)"
                                                                    data-toggle="modal" data-target='#editMatiere_modal'
                                                                    data-id="{{ $matiere->id }}"
                                                                    data-matiere ="{{ $matiere }}"
                                                                    data-name={{ $matiere->name }}
                                                                    data-description={{ $matiere->description }}><i
                                                                        class="fas fa-edit "></i></a>
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
                                        <th>Libellé</th>
                                        <th>Unité d'enseignement</th>
                                        <th>semestre</th>
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="modal fade" id="editMatiere_modal" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Modifier une matière </h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <form method="POST" action="{{ route('matieres.update', $matiere) }}">
                                        @csrf
                                        @method('PATCH')
                                        <div class="modal-body">
                                            <div class="card-body">
                                                <input type="hidden" name="matiere_id" id="matiere_id"
                                                    value="{{ $matiere->id }}">
                                                <div class="form-group">
                                                    <label for="name">Nom de la matière</label>
                                                    <input required type="text" class="form-control" id="name"
                                                        name="name" value="{{ $matiere->name }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Choisir l'UE</label>
                                                    <select name="ue_id" id="ue_idPATCH" class="custom-select select2">
                                                        <option value="{{ $matiere->ue->id }}">
                                                            {{ $matiere->ue->name }} ({{ $matiere->ue->code }})
                                                        </option>
                                                        @foreach ($ues as $ue)
                                                            <option value="{{ $ue->id }}">{{ $ue->name }}
                                                                ({{ $ue->code }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label>Choisir le(s) semestre(s)</label>
                                                    <div id="semestres_containerP">
                                                        <!-- Les cases à cocher pour les semestres seront générées ici -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default"
                                                data-dismiss="modal">Fermer</button>
                                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        var semestresAffectes = {!! json_encode($matiere->semestres->pluck('id')->toArray()) !!};
    </script>

    <script>
        $(document).ready(function() {
            $('#ue_id').change(function() {
                var ueId = $(this).val();
                var matiereId = $('#matiere_id').val(); // Récupérer l'ID de la matière sélectionnée
                if (ueId) {
                    $.ajax({
                        type: "GET",
                        url: "{{ url('ues') }}/" + ueId + "/semestres/" +
                            matiereId, // Passer l'ID de la matière à l'API
                        success: function(semestres) {
                            $('#semestres_container').empty();
                            $.each(semestres, function(key, semestre) {
                                var checkbox = $('<input>').attr({
                                    type: 'checkbox',
                                    class: 'custom-control-input',
                                    id: 'semestre_' + semestre.id,
                                    name: 'semestres[]',
                                    value: semestre.id,
                                });
                                var label = $('<label>').addClass(
                                        'custom-control-label')
                                    .attr('for', 'semestre_' + semestre.id)
                                    .text(semestre.name + ' (' + semestre.level_code +
                                        ')');
                                var div = $('<div>').addClass(
                                        'custom-control custom-checkbox')
                                    .append(checkbox)
                                    .append(label);
                                $('#semestres_container').append(div);

                            });
                        }
                    });
                } else {
                    $('#semestres_container').empty();
                }
            });
        });
    </script>

    <script>
        var semestresAffectes = {!! json_encode($matiere->semestres->pluck('id')->toArray()) !!};
    </script>
    <script>
        // Fonction pour remplir le formulaire de mise à jour avec les données de la matière sélectionnée
        function editMatiere(el) {
            var link = $(el);
            var matiere = link.data('matiere');
            var ueSemestres = link.data('uesemestres');

            var modal = $("#editMatiere_modal");

            modal.find('#matiere_id').val(matiere.id);
            // Remplir les champs du formulaire avec les données de la matière sélectionnée
            modal.find('#name').val(matiere.name);

            // Remplir les champs pour l'UE
            modal.find('#ue_idPATCH').val(matiere.ue.id);

            // Charger et afficher les semestres liés à l'UE sélectionnée
            $('#ue_idPATCH').val(matiere.ue.id).change();

            // Vous pouvez ajouter d'autres données de la matière ici si nécessaire
        }
        $(document).ready(function() {
            $('#ue_idPATCH').change(function() {
                var ueId = $(this).val();
                var matiereId = $('#matiere_id').val(); // Récupérer l'ID de la matière sélectionnée
                if (ueId) {
                    $.ajax({
                        type: "GET",
                        url: "{{ url('ues') }}/" + ueId + "/semestres/" +
                            matiereId, // Passer l'ID de la matière à l'API
                        success: function(semestres) {
                            $('#semestres_containerP').empty();
                            $.each(semestres, function(key, semestre) {
                                var checkbox = $('<input>').attr({
                                    type: 'checkbox',
                                    class: 'custom-control-input',
                                    id: 'semestre_' + semestre.id,
                                    name: 'semestres[]',
                                    value: semestre.id,
                                });
                                var label = $('<label>').addClass(
                                        'custom-control-label')
                                    .attr('for', 'semestre_' + semestre.id)
                                    .text(semestre.name + ' (' + semestre.level_code +
                                        ')');
                                var div = $('<div>').addClass(
                                        'custom-control custom-checkbox')
                                    .append(checkbox)
                                    .append(label);
                                $('#semestres_containerP').append(div);

                                // Vérifier si le semestre est lié à la matière
                                if (semestre.mat_matiere) {
                                    checkbox.prop('checked', true);
                                }
                            });
                        }
                    });
                } else {
                    $('#semestres_containerP').empty();
                }
            });
        });
    </script>
   





@stop
