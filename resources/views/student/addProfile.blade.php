@extends('layouts.app')

@section('title', 'Ajout de photo de profil')
@section('content')


    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title ">Ajouter votre photo de profil</h3>
                            <a class="btn btn-info float-right" href="{{ route('profil.image') }}">Voir ma photo </a>
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
                            <form class="form-horizontal" method="post" action="{{ route('addingProfil', ['id' => $student->id]) }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">

                                    <div class="form-group row">
                                        <label for="exampleInputFile" class="col-sm-2 col-form-label"> Ajouter une image:</label>
                                        <div class="col-sm-10">

                                            <div class="input-group">
                                                <div class="">
                                                    <input type="file"
                                                    id="avatar" name="file"
                                                    accept="image/png, image/jpeg">
                                                    
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-info float-right">Envoyé</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>
@stop
