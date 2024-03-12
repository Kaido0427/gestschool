@extends('layouts.app')

@section('title', 'Modifier une filières')
@section('title_p', 'Gestion des filières')
@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Modifier une filière</h3>
                            <a class="btn btn-primary float-right" href="{{ route('sectors.index') }}">Voir la liste</a>

                        </div>
                        <div class="card-body">
                            @if ($message = Session::get('error'))
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                                    <p>{{ $message }}</p>
                                </div>
                            @endif
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                                    <p>{{ $message }}</p>
                                </div>
                            @endif
                            <form class="form-horizontal" method="post" action="/sectors/{{ $sector->id }}">
                                @method('PATCH')
                                @csrf

                                <div class="modal-body">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="name">Nom de la filière</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ $sector['name'] }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="code">Code de la filière</label>
                                            <input type="text" class="form-control" id="code" name="code"
                                                value="{{ $sector['code'] }}">
                                        </div>

                                    </div>

                                </div>

                               
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-info float-right">Modifier</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

@stop
