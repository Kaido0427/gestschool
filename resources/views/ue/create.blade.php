@extends('layouts.app')

@section('title', 'Enregistrement des Ues et des matieres')
@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Enregistrer des Unités d'enseignement</h3>
                            <a class="btn btn-primary float-right" href="{{ route('ues.index') }}">Voir la liste</a>

                        </div>
                        <div class="card-body">
                            <form class="form-horizontal" method="post" action="{{ route('ues.store') }}">
                                @csrf

                                <fieldset>

                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="name">Libellé</label>
                                            <input type="text" class="form-control" required id="name"
                                                name="name" placeholder="Example: Anatomie et Physiologie Mentale">
                                        </div>
                                        <div class="form-group">
                                            <label for="code">Code</label>
                                            <input type="text" class="form-control" id="code" name="code"
                                                placeholder="Example: APM5114">
                                        </div>

                                        <div class="form-group">
                                            <label for="type">Type </label>

                                            <select required name="type" class="custom-select select2">
                                                <option value="">Choisir le type</option>
                                                <option value="UE DE SPECIALITE">
                                                    {{ 'UE DE SPECIALITE' }}
                                                </option>
                                                <option value="UE DE METHODOLOGIE">
                                                    {{ 'UE DE METHODOLOGIE' }}
                                                </option>
                                                <option value="UE CULTURE GÉNÉRALE">
                                                    {{ 'UE CULTURE GÉNÉRALE' }}
                                                </option>

                                                <option value="UE DE CONNAISSANCES FONDAMENTALES">
                                                    {{ 'UE DE CONNAISSANCES FONDAMENTALES' }}
                                                </option>

                                            </select>


                                        </div>

                                        <div class="form-group">
                                            <label for="inputPhone3" class="">Veuillez choisir le(s) semestre(s) de
                                                cette UE</label>
                                            <div class="col-sm-10">
                                                <div class="form-group clearfix">
                                                    @foreach ($semestres as $semestre)
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="semestre_{{ $semestre->id }}"
                                                                name="semestres[]" value="{{ $semestre->id }}">
                                                            <label for="semestre_{{ $semestre->id }}">
                                                                {{ $semestre->name }}({{ $semestre->level->code }})
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                    <br>

                                                    <br>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </fieldset>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-info float-right">Enregistrer</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

@stop
