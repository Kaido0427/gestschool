@extends('layouts.login')

@section('title', 'Connexion')
@section('content')

<div class="hold-transition login-page">
    <div class="login-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
        <img src="{{URL::asset('dist/img/logo.png')}}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <h6><b>{{env('APP_NAME')}} <b></h6>
        </div>
        <div class="card-body">
        <p class="login-box-msg">Formulaire de connexion</p>
             @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                
                        <p>{{ $message }}</p>
                    </div> 
                @endif
                    
        <form class="form-horizontal" method="post" action="{{ route('auth.login') }}">
        @csrf
            <div class="input-group mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email admin">
            <div class="input-group-append">
                <div class="input-group-text">
                <span class="fas fa-envelope"></span>
                </div>
            </div>
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
                <button type="submit" class="btn btn-primary btn-block">Connexion</button>
            </div>
            </div>
        </form>

        </div>
    </div>
    </div>
</div>

@stop