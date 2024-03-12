@extends('layouts.app')

@section('title', 'détail d\'une classe')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $classes->name }}</h1>
                </div>
               
            </div>
        </div>
    </section>
    <section class="content">

        <div class="card">
            <div class="card-header">
                <!-- Button pour afficher le modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-classe">
                    Cliquer ici pour modifier une classe
                </button>

                <!-- Modal -->
                <div class="modal fade" id="add-classe" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Modifier une classe</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <!-- Formulaire -->
                            <form method="POST" action="{{ route('classes.update', $classes->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Modifier la filière</label>
                                            <select required name="sector_id" class="custom-select select2">
                                                <option value="">Choisir une filière</option>
                                                @foreach ($sectors as $sector)
                                                    <option value="{{ $sector->id }}"
                                                        {{ $classes->sector_id == $sector->id ? 'selected' : '' }}>
                                                        {{ $sector->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Modifier le niveau d'étude</label>
                                            <select name="level_id" required class="custom-select select2">
                                                <option value="">Choisir un niveau d'étude</option>
                                                @foreach ($levels as $level)
                                                    <option value="{{ $level->id }}"
                                                        {{ $classes->level_id == $level->id ? 'selected' : '' }}>
                                                        {{ $level->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                Footer
            </div>
        </div>

</section @stop
