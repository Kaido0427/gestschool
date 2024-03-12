@extends('layouts.app')

@section('title', 'Bulletins')
@section('content')

    <h1 class="text-center text-uppercase font-weight-bold">Promotion <span
            class="text-danger">{{ $getPromotion->name }}</span></h1>
    <h2 class="text-center text-uppercase font-weight-bold">Classe: <span
            class="text-danger">{{ $userClasse->mclass->name }}</span></h2>


    <div>

        <table border="1">
            <thead>
                <tr>
                    <th rowspan="2">N°</th>
                    <th rowspan="2">ELEMENTS CONSTITUTIFS D'UNITES</th>
                    <th colspan="2">CONTRÔLE CONTINU (40%)</th>
                    <th colspan="2">EXAMENS (60%)</th>
                    <th rowspan="2"> MOY COEF / 20</th>
                    <th rowspan="2">CREDITS VALIDES</th>

                </tr>
                <tr>
                    <th>Note / 20</th>
                    <th>Note Coéf</th>

                    <th>Note / 20</th>
                    <th>Note Coéf</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $num = 1;
                $sumCredit = 0;
                $sumAVG = 0;
                ?>
                @foreach ($matieres as $matiere)
                    <tr>
                        <td>{{ $num }}</td>
                        <td>{{ $matiere->name }}</td>
                        <td>{{ count($matiere->matiereTeachers) && count($matiere->evaluation) && $matiere->evaluation[0]['controle'] ? $matiere->evaluation[0]['controle'] / 0.4 : '' }}
                        </td>
                        <td>{{ count($matiere->matiereTeachers) && count($matiere->evaluation) && $matiere->evaluation[0]['controle'] ? $matiere->evaluation[0]['controle'] : '' }}
                        </td>

                        <td>{{ count($matiere->matiereTeachers) && count($matiere->evaluation) && $matiere->evaluation[0]['examen'] ? $matiere->evaluation[0]['examen'] / 0.6 : '' }}
                        </td>
                        <td>{{ count($matiere->matiereTeachers) && count($matiere->evaluation) && $matiere->evaluation[0]['examen'] ? $matiere->evaluation[0]['examen'] : '' }}
                        </td>

                        <td>{{ count($matiere->matiereTeachers) && count($matiere->evaluation) && $matiere->evaluation[0]['examen'] && $matiere->evaluation[0]['controle'] ? $matiere->evaluation[0]['examen'] + $matiere->evaluation[0]['controle'] : '' }}
                        </td>
                        <td>{{ count($matiere->matiereTeachers) ? $matiere['matiereClasses'][0]['credit_number'] : '' }}
                        </td>
                    <tr>

                        <?php
                        
                        if (count($matiere->matiereTeachers) && count($matiere->evaluation) && $matiere->evaluation[0]['examen'] && $matiere->evaluation[0]['controle']) {
                            if ($matiere->evaluation[0]['examen'] + $matiere->evaluation[0]['controle'] > 12) {
                                $sumCredit += $matiere['matiereClasses'][0]['credit_number'];
                            }

                            $sumAVG += $matiere->evaluation[0]['examen'] + $matiere->evaluation[0]['controle'];

                        }
                        
                        $num++;
                        
                        ?>
                @endforeach
            </tbody>


            <tfoot>
                <tr>
                    <th class="text-center" colspan="2">TOTAL CREDITS VALIDES</th>
                    <th class="text-center" colspan="7">{{ $sumCredit ? $sumCredit : '' }}</th>

                </tr>
                <tr>
                    <th class="text-center" colspan="2">MOYENNE SEMESTRIELLE</th>
                    <th class="text-center" colspan="7">{{$sumAVG ? $sumAVG : ''}}</th>

                </tr>
            </tfoot>

        </table>
    </div>
    <br>
@stop
