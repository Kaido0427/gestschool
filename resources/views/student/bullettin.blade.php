@extends('layouts.app')

@section('title', 'Liste des promotions')
@section('content')
    <section class="content">
        <h1 class="text-center text-uppercase font-weight-bold">Bulletins par promotion</h1>

        <div class="row">
            @foreach ($userClasseWithPromotion as $promotion)
                <div class="col-lg-4 col-6">
                    <div class="card">
                        <div class="card-header bg-secondary">
                            <h3 class="card-title text-dark">Promotion : {{ $promotion->promotion->name }}</h3>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Classe: {{ $promotion->mclass->name }}</p>

                            @if (Auth::user()->type == 'admin')
                                @php
                                    $semestres = $semestresByPromotion[$promotion->promotion->name];
                                @endphp
                                <div class="text-center">
                                    @foreach ($semestres as $semestre)
                                        <div class="btn-group mt-3" role="group" aria-label="Semestre Links">
                                            <a href="{{ route('student-bulletin', ['promotion' => $promotion->promotion->name, 'user' => $user->id, 'semestre' => $semestre->semestre_id]) }}"
                                                class="btn btn-outline-primary">
                                                {{ $semestre->semestre_name }}
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center">
                                    @php
                                        $semestres = $semestresByPromotion[$promotion->promotion->name];
                                    @endphp
                                    <div class="text-center">
                                        @foreach ($semestres as $semestre)
                                            <a target="_blank"
                                                href="bulletin/{{ $promotion->promotion->name }}/{{ $semestre->semestre_id }}"
                                                class="btn btn-outline-primary">{{ $semestre->semestre_name }}
                                                <i class="fas fa-arrow-circle-right"></i>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@stop
