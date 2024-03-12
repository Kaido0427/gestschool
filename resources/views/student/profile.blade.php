@extends('layouts.app')

@section('title', 'Ajout de photo de profil')
@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title ">Photo d'identité</h3>
                         
                        </div>
                        <div class="card-body">
                            <div>
                                @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true">×</button>

                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @if ($message = Session::get('success'))
                                    <div class="alert alert-success alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-hidden="true">×</button>

                                        <p>{{ $message }}</p>
                                    </div>
                                @endif
                            </div>

                            <div class="card-body">

                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        @if ($image)
                                            <div class="input-group">
                                                <img src="{{ asset('images/' . $image['url']) }}" alt=""
                                                    srcset="" width="200" height="200">
                                            </div>
                                        @else
                                            <div>
                                                <p>Vous avez pas ajouté de photo </p>
                                                <a href="{{ route('addProfil', ['id' => $user->id]) }}" class="btn btn-success">Ajouter une photo</a>
                                            </div>
                                        @endif


                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>


@stop
