@extends('layouts.login')

@section('title', 'Enregistrement Enseignant')
@section('content')

<div class="hold-transition login-page">
    <div class="login-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
        <img src="{{URL::asset('dist/img/logo.png')}}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <h6><b>{{ env('APP_NAME') }} <b></h6>
        </div>
        <div class="card-body">
        <p class="login-box-msg">Formulaire d'enregistrement</p>

        <form class="form-horizontal" method="post" action="{{ route('teacher.save') }}">
             @csrf
             <div class="input-group mb-3">
                <input type="text" name="name" class="form-control" placeholder="Nom">
                
            </div>
            <div class="input-group mb-3">

                <input type="text" name="firstname" class="form-control" placeholder="Prénom(s)">
                
            </div>
            <div class="input-group mb-3">

                <input type="text" name="gender" class="form-control" placeholder="Genre, ex:M">
                
            </div>

            <div class="input-group mb-3">
                <input type="text" name="phone" class="form-control" placeholder="Téléphone">
                
            </div>
            <div class="input-group mb-3">

                <input type="text" name="address" class="form-control" placeholder="Adresse complète">
                
            </div>
 
            <div class="input-group mb-3">

                <input type="email" name="email" class="form-control" placeholder="Email">
                
            </div>
            <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Mot de passe">
            <div class="input-group-append">
                <div class="input-group-text">
                <span class="fas fa-lock"></span>
                </div>
            </div>
            </div>
            <div class="row">
            <div class="col-7">
                <div class="icheck-primary">
                
                </div>
            </div>
            <div class="col-5">
                <button type="submit" class="btn btn-primary btn-block">S'inscrire</button>
            </div>
            </div>
        </form>

        </div>
    </div>
    </div>
</div>

@stop