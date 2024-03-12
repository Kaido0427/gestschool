@extends('layouts.app')

@section('title', 'Bulletins')
@section('content')

    <h1 class="text-center text-uppercase font-weight-bold">Promotion <span class="text-danger">{{ $getPromotion->name }}</span></h1>
    <h2 class="text-center text-uppercase font-weight-bold">Classe: <span class="text-danger">{{ $userClasse->mclass->name }}</span></h2>

    {{ $ues[0] ? $ues[0]['matieres'][1]['matiereClasses'][0]['credit_number']: "" }}

    <div>

        <table border="1">
            <thead>
                <tr rowspan="2">
                    <th>UE</th>
                    <th>Matiere</th>
                    <th>Enseignant</th>
                    <th>Noté sur</th>
                    <th colspan="2">Controle continu</th>
                    <th colspan="2">Examen</th>
                    <th >Moyenne Coef</th>
                    <th >Crédit</th>

                </tr>
            </thead>
            <? $sumAvg = 0 ?>
            <tbody>
                @foreach ($ues as $ue)
                    <tr>
                        <td rowspan="{{ $ue->matieres->count() }}">{{ $ue->name }}</td>
                        @foreach ($ue->matieres as $key => $matiere)
                            @if ($key > 0)
                    <tr>
                @endif
                <td>{{ $matiere->name }}</td>
                <td>{{ count($matiere->matiereTeachers) ? $matiere->matiereTeachers[0]['teacher']['name']." ".$matiere->matiereTeachers[0]['teacher']['firstname']:'' }}</td>
                <td>{{ count($matiere->matiereTeachers) && count($matiere->matiereClasses)   ? $matiere->matiereClasses[0]['max_note']:'' }}</td>
                <td>{{ count($matiere->matiereTeachers) && count($matiere->evaluation)   ? $matiere->evaluation[0]['examen']/ 0.6 :'' }}</td>
                <td>{{ count($matiere->matiereTeachers) && count($matiere->evaluation)   ? $matiere->evaluation[0]['examen'] :'' }}</td>
                <td>{{ count($matiere->matiereTeachers) && count($matiere->evaluation)   ? $matiere->evaluation[0]['controle']/ 0.4 :'' }}</td>
                <td>{{ count($matiere->matiereTeachers) && count($matiere->evaluation)   ? $matiere->evaluation[0]['controle']:'' }}</td>
                <td>{{ count($matiere->matiereTeachers) && count($matiere->evaluation)   ? $matiere->evaluation[0]['controle'] + $matiere->evaluation[0]['examen'] :'' }}</td>
                <td>{{ count($matiere->matiereTeachers) && count($matiere->evaluation)   ? $matiere :'' }}</td>
                @if ($key > 0)
                    </tr>
                @endif
                @endforeach
                </tr>
                @endforeach

            </tbody>

            <tfoot>
                <tr>
                    <th class="text-center" colspan="4">TOTAL CREDITS VALIDES</th>
                    <th class="text-center" colspan="5">ok</th>

                </tr>
               
            </tfoot>
            <tfoot>
                <tr>
                    <th class="text-center" colspan="4">Moyenne Semestrielle</th>
                    <th class="text-center" colspan="5">ok</th>

                </tr>
            </tfoot>

        </table>
    </div>
    <br>
@stop
