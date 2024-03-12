@extends('layouts.app')

@section('title', 'Statistique')
@section('content')
    <section class="content">

        <h1 class="text-center"> Liste des classes </h1>

        <div class="row">
            @foreach ($classes as $classe)
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $classe->name }}</h3>

                            <h4> {{ count($classe->students) }} {{ 'Etudiants' }}</h4>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person"></i>
                        </div>
                        <a href="classe/{{ $classe->id }}/students" class="small-box-footer">Voir plus <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            @endforeach

        </div>
    </section>

@stop
