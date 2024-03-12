<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Bulletin</title>
    <style>
        *,
        *::before,
        *::after {
            margin: 0px;
            padding: 0px;
            box-sizing: border-box;
        }

        header {
            width: 100%;
            height: 150px;
            background: url("https://i.postimg.cc/SsL1434N/ENT-TE4-JP-UCAO.jpg");
            background-repeat: no-repeat;
            background-position: center center;
            background-size: cover;
            position: absolute;
            top: 0px;
            left: 0px;
            overflow: hidden;
        }

        .header {
            width: 100%;
            height: 150px;
            background-repeat: no-repeat;
            background-position: center center;
            background-size: cover;
            position: absolute;
            top: 0px;
            left: 0px;
            overflow: hidden;
            margin-bottom: 40px
        }

        table {
            border: 1px solid black;
            margin-left: 65px;
            width: 90%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 2px;
        }

        th {
            text-align: start;
            background-color: #e2efd9;
            padding-left: 20px
        }

        ul {
            padding-left: 20px;
            list-style-type: decimal;
            list-style-position: outside;
            margin-left: 20px;
        }

        li {
            margin: 5px
        }

        input {
            margin: 5px;
        }

        .img {
            top: 870px;
            margin-left: 120px;
            position: absolute;
        }

        .ul-check {
            list-style-image: url('https://i.postimg.cc/yNGNXfnr/2422422-200.png');
            margin-left: 30px;
            margin-right: 20px"

        }

        ,
    </style>
</head>

<body>
    <header>
        <div>
        </div>
    </header>

    <h3 style="text-align: center; margin-top: 150px">
        Relevé de Notes {{ $semestreObjet->name }}
    </h3>
    <div style="height: 10px"></div>

    <main>
        <style>
            .div1,
            .div2 {
                display: inline-block;
                margin-left: 45px
            }

            ,
            .div1 {
                float: left;
            }

            .div2 {
                float: right;
                margin-right: 65px
            }
        </style>

        <div class="div1">
            <h3 style="margin-top: 2px">
                {{ $getUser->name . ' ' . $getUser->firstname }}
            </h3>
            <h4 style="margin-top: 2px">Date de Naissance :
                {{ explode(' ', $getUser->birth_day)[0] }} </h4>
            <h4 style="margin-top: 2px">Lieu de Naissance : {{ $getUser->birth_place }} </h4>
            <h4 style="margin-top: 2px">N°Matricule : {{ $getUser->matricule }}</h4>
        </div>
        <div class="div2">

            <h3 style="margin-left: -90px; margin-top: 2px">
                Année Académique : {{ $getPromotionName }}
            </h3>
            <h4 style="margin-left: -90px; margin-top: 2px">Filière : {{ $userClasse->mclass->sector->name }} </h4>
            <h4 style="margin-left: -90px; margin-top: 2px">Niveau d'étude : {{ $userClasse->mclass->level->name }}
            </h4>
        </div>

        <div style="margin-top:2.5cm"></div>

        <table style="margin-left:35px">

            <thead>
                <tr>
                    <th style="text-align: center;" rowspan="2">N°</th>
                    <th style="text-align: center;" rowspan="2">ELEMENTS CONSTITUTIFS D'UNITES</th>
                    <th style="text-align: center;" colspan="2">CONTRÔLE CONTINU (40%)</th>
                    <th style="text-align: center;" colspan="2">EXAMENS (60%)</th>
                    <th style="text-align: center;" rowspan="2"> MOY COEF / 20</th>
                    <th style="text-align: center;" rowspan="2">CREDITS VALIDES</th>

                </tr>
                <tr>
                    <th style="text-align: center;">Note / 20</th>
                    <th style="text-align: center;">Note Coéf</th>

                    <th style="text-align: center;">Note / 20</th>
                    <th style="text-align: center;">Note Coéf</th>
                </tr>
            </thead>

            @php

                $num = 1;
                $sumCredit = 0;
                $sumAVG = 0;

                $sumAVGEcuFond = 0;
                $sumAVGSEM = 0;
            @endphp
            <tbody>
                <tr>
                    <td colspan="8" style="text-align: center; font-weight:bold">ECU FONDAMENTAUX</td>
                </tr>
                @foreach ($matieres as $matiere)
                    <tr>
                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                        <td style="text-align: center;">{{ $matiere->matiere_name }}</td>
                        <td style="text-align: center;">
                            {{ $matiere->controle ? $matiere->controle / 0.4 : '' }}
                        </td>
                        <td style="text-align: center;">
                            {{ $matiere->controle ? $matiere->controle : '' }}
                        </td>
                        <td style="text-align: center;">
                            {{ $matiere->examen ? $matiere->examen / 0.6 : '' }}
                        </td>
                        <td style="text-align: center;">
                            {{ $matiere->examen ? $matiere->examen : '' }}
                        </td>
                        <td style="text-align: center;">
                            {{ $matiere->examen && $matiere->controle ? $matiere->examen + $matiere->controle : '' }}
                        </td>
                        <td style="text-align: center;">
                            {{ $matiere->credit_number ?? '' }}
                        </td>

                        <?php
                        if ($matiere->examen && $matiere->controle) {
                            $sumAVGEcuFond += $matiere->examen + $matiere->controle;
                            if ($matiere->examen + $matiere->controle > 12) {
                                $sumCredit += $matiere->credit_number ?? 0;
                            }
                        }
                        ?>
                    </tr>
                @endforeach


                <tr>
                    <td style="text-align: center; font-weight:bold" colspan="6">Moyenne ECU Fondamentaux (80%)</td>
                    <td style="text-align: center; font-weight:bold" colspan="2">
                        {{ $sumAVGEcuFond ? ($sumAVGEcuFond * 0.8) / count($matieres) : '' }} </td>
                </tr>

                <tr>
                    <td style="text-align: center; font-weight:bold" colspan="8">SEMINAIRE ET TRAVAUX PRATIQUES</td>
                </tr>

                <!--Afficher les matiere et les notes pour ce type d'UE precisement
                Besoin de plus d'information pour ecrire un algorithme
            -->

                <tr>
                    <td style="text-align: center; font-weight:bold" colspan="6">Moyenne Séminaire et Travaux
                        Pratiques (20%)</td>
                    <td style="text-align: center; font-weight:bold" colspan="2">
                        {{ $sumAVGSEM ? $sumAVGSEM * 0.2 : '' }} </td>
                </tr>
            </tbody>

            <tfoot>
                <tr>
                    <th style="text-align: center; font-weight:bold" colspan="6">
                        TOTAL CREDITS VALIDES
                    </th>
                    <th style="text-align: center; font-weight:bold" colspan="2">
                        {{ $sumCredit ? $sumCredit : '' }}
                    </th>

                </tr>
                <tr>
                    <th style="text-align: center; font-weight:bold" colspan="6">
                        MOYENNE SEMESTRIELLE
                    </th>
                    <th style="text-align: center; font-weight:bold" colspan="2">
                        {{ $sumAVGSEM + $sumAVGEcuFond ? $sumAVGSEM + $sumAVGEcuFond / count($matieres) : '' }}
                    </th>

                </tr>
            </tfoot>
        </table>

        <div style="height: 20px"></div>

        <div class="div1">

        </div>
        <div class="div2">

            <h3 style="margin-left: -200px; margin-top: 2px">
                Fait à Cotonou, le
            </h3>
            <div style="height: 50px"></div>

            <h4 style="margin-left: -200px; margin-top: 2px">LE DIRECTEUR DES ETUDES</h4>
            <div style="height: 40px"></div>

            <h4 style="margin-left: -200px; margin-top: 2px">Dr. P. Dominique-Rosario AGBALENYO </h4>
        </div>

        <div style="height: 50px"></div>

    </main>
</body>

</html>
