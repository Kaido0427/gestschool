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

        body {
            font-size: 13px;
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
                Année Académique : {{ $getPromotion->name }}
            </h3>
            <h4 style="margin-left: -90px; margin-top: 2px">Filière : {{ $userClasse->mclass->sector->name }} </h4>
            <h4 style="margin-left: -90px; margin-top: 2px">Niveau d'étude : {{ $userClasse->mclass->level->name }}
                @if ($getUser->night === 1)
                    (Cours du Soir)
                @else
                    (Cours du jour)
                @endif
            </h4>
        </div>

        <div style="margin-top:2.5cm"></div>

        @if ($getUser->night === 1)
            @php
                $matieresnight = $matieres->filter(function ($matiere) use ($getUser) {
                    return $matiere->night === 1;
                });
            @endphp
            @if (strpos($semestreObjet->name, '1') !== false ||
                    strpos($semestreObjet->name, '3') !== false ||
                    strpos($semestreObjet->name, '5') !== false ||
                    strpos($semestreObjet->name, '1 (MA)') !== false ||
                    strpos($semestreObjet->name, '3 (MA)') !== false ||
                    strpos($semestreObjet->name, '4 (MA)') !== false ||
                    strpos($semestreObjet->name, '1 (LC)') !== false ||
                    strpos($semestreObjet->name, '3 (LC)') !== false ||
                    strpos($semestreObjet->name, '4 (LC)') !== false ||
                    strpos($semestreObjet->name, '6') !== false)
                <table style="margin-left:35px">
                    <thead>
                        <tr>
                            <th style="text-align: center;" rowspan="2">N°</th>
                            <th style="text-align: center;" rowspan="2">ELEMENTS CONSTITUTIFS D'UNITES</th>
                            <th style="text-align: center;" colspan="2">CONTRÔLE CONTINU (40%)</th>
                            <th style="text-align: center;" colspan="2">EXAMENS (60%)</th>
                            <th style="text-align: center;" rowspan="2"> MOY COEF / {{ $max }}</th>
                            <th style="text-align: center;" rowspan="2">CREDITS VALIDES</th>

                        </tr>
                        <tr>
                            <th style="text-align: center;">Note / {{ $max }}</th>
                            <th style="text-align: center;">Note Coéf</th>

                            <th style="text-align: center;">Note / {{ $max }}</th>
                            <th style="text-align: center;">Note Coéf</th>
                        </tr>
                    </thead>

                    @php
                        $num = 1;
                        $sumCredit = 0;
                        $sumAVGEcuFond = 0;
                        $countMatieresAvecNotes = 0;
                    @endphp

                    <tbody>
                        @foreach ($matieresnight as $matiere)
                            <tr>
                                <td style="text-align: center;">{{ $loop->iteration }}</td>
                                <td style="text-align: center;">{{ $matiere->matiere_name }}</td>
                                <td style="text-align: center;">
                                    {{ $matiere->controle ? $matiere->controle / 0.4 : '' }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $matiere->controle ?? '' }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $matiere->examen ? $matiere->examen / 0.6 : '' }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $matiere->examen ?? '' }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $matiere->examen && $matiere->controle ? $matiere->examen + $matiere->controle : '' }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $matiere->credit_number ?? '' }}
                                </td>

                                @if ($matiere->examen && $matiere->controle)
                                    @php
                                        $sumAVGEcuFond += $matiere->examen + $matiere->controle;
                                        if ($matiere->examen + $matiere->controle > 12) {
                                            $sumCredit += $matiere->credit_number ?? 0;
                                        }
                                        $countMatieresAvecNotes++;
                                    @endphp
                                @endif
                            </tr>
                        @endforeach
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
                                @if ($countMatieresAvecNotes > 0)
                                    {{ number_format($sumAVGEcuFond / $countMatieresAvecNotes, 2) }}
                                @else
                                    N/A
                                @endif
                            </th>
                        </tr>
                    </tfoot>

                </table>
            @endif
        @else
            @php
                $matieresday = $matieres->filter(function ($matiere) use ($getUser) {
                    return $matiere->night === 0;
                });
            @endphp
            @if (strpos($semestreObjet->name, '1') !== false ||
                    strpos($semestreObjet->name, '3') !== false ||
                    strpos($semestreObjet->name, '5') !== false ||
                    strpos($semestreObjet->name, '1 (MA)') !== false ||
                    strpos($semestreObjet->name, '3 (MA)') !== false ||
                    strpos($semestreObjet->name, '4 (MA)') !== false ||
                    strpos($semestreObjet->name, '1 (LC)') !== false ||
                    strpos($semestreObjet->name, '3 (LC)') !== false ||
                    strpos($semestreObjet->name, '4 (LC)') !== false ||
                    strpos($semestreObjet->name, '6') !== false)
                <table style="margin-left:35px">
                    <thead>
                        <tr>
                            <th style="text-align: center;" rowspan="2">N°</th>
                            <th style="text-align: center;" rowspan="2">ELEMENTS CONSTITUTIFS D'UNITES</th>
                            <th style="text-align: center;" colspan="2">CONTRÔLE CONTINU (40%)</th>
                            <th style="text-align: center;" colspan="2">EXAMENS (60%)</th>
                            <th style="text-align: center;" rowspan="2"> MOY COEF / {{ $max }}</th>
                            <th style="text-align: center;" rowspan="2">CREDITS VALIDES</th>

                        </tr>
                        <tr>
                            <th style="text-align: center;">Note / {{ $max }}</th>
                            <th style="text-align: center;">Note Coéf</th>

                            <th style="text-align: center;">Note / {{ $max }}</th>
                            <th style="text-align: center;">Note Coéf</th>
                        </tr>
                    </thead>

                    @php
                        $num = 1;
                        $sumCredit = 0;
                        $sumAVGEcuFond = 0;
                        $countMatieresAvecNotes = 0;
                    @endphp

                    <tbody>
                        @foreach ($matieresday as $matiere)
                            <tr>
                                <td style="text-align: center;">{{ $loop->iteration }}</td>
                                <td style="text-align: center;">{{ $matiere->matiere_name }}</td>
                                <td style="text-align: center;">
                                    {{ $matiere->controle ? $matiere->controle / 0.4 : '' }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $matiere->controle ?? '' }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $matiere->examen ? $matiere->examen / 0.6 : '' }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $matiere->examen ?? '' }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $matiere->examen && $matiere->controle ? $matiere->examen + $matiere->controle : '' }}
                                </td>
                                <td style="text-align: center;">
                                    {{ $matiere->credit_number ?? '' }}
                                </td>

                                @if ($matiere->examen && $matiere->controle)
                                    @php
                                        $sumAVGEcuFond += $matiere->examen + $matiere->controle;
                                        if ($matiere->examen + $matiere->controle > 12) {
                                            $sumCredit += $matiere->credit_number ?? 0;
                                        }
                                        $countMatieresAvecNotes++;
                                    @endphp
                                @endif
                            </tr>
                        @endforeach
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
                                @if ($countMatieresAvecNotes > 0)
                                    {{ number_format($sumAVGEcuFond / $countMatieresAvecNotes, 2) }}
                                @else
                                    N/A
                                @endif
                            </th>
                        </tr>
                    </tfoot>

                </table>
            @endif
        @endif


        @if ($getUser->night === 1)
            @php
                $matieresnight = $matieres->filter(function ($matiere) use ($getUser) {
                    return $matiere->night === 1;
                });
            @endphp
            @if (strpos($semestreObjet->name, '2') !== false ||
                    strpos($semestreObjet->name, '2 (LC)') !== false ||
                    strpos($semestreObjet->name, '2 (MA)') !== false ||
                    strpos($semestreObjet->name, '4') !== false)
                <table style="margin-left:35px">
                    <thead>
                        <tr>
                            <th style="text-align: center;" rowspan="2">N°</th>
                            <th style="text-align: center;" rowspan="2">ELEMENTS CONSTITUTIFS D'UNITES</th>
                            <th style="text-align: center;" colspan="2">CONTRÔLE CONTINU (40%)</th>
                            <th style="text-align: center;" colspan="2">EXAMENS (60%)</th>
                            <th style="text-align: center;" rowspan="2">MOY COEF /{{ $max }}</th>
                            <th style="text-align: center;" rowspan="2">CREDITS VALIDES</th>
                        </tr>
                        <tr>
                            <th style="text-align: center;">Note / {{ $max }}</th>
                            <th style="text-align: center;">Note Coéf</th>
                            <th style="text-align: center;">Note / {{ $max }}</th>
                            <th style="text-align: center;">Note Coéf</th>
                        </tr>
                    </thead>
                    @php
                        $num = 1;
                        $sumCredit = 0;
                        $sumAVGEcuFond = 0;
                        $sumAVGEcuFond = 0;
                        $countMatieresEcuFond = 0;
                        $sumAVGSEM = 0;
                        $countMatieresSeminaire = 0;
                        $countMatieresSeminaire = 0;
                    @endphp
                    <tbody>
                        <tr>
                            <td style="text-align: center; font-weight:bold" colspan="8">ECU FONDAMENTAUX</td>
                        </tr>
                        <!-- Affichage des matières pour les écus fondamentaux -->
                        @foreach ($matieresnight as $matiere)
                            @if (!(strpos($matiere->matiere_name, 'Séminaire') !== false || strpos($matiere->matiere_name, 'stage') !== false))
                                <tr>
                                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                                    <td style="text-align: center;">{{ $matiere->matiere_name }}</td>
                                    <td style="text-align: center;">
                                        {{ $matiere->controle ? $matiere->controle : '' }}
                                    </td>
                                    <td style="text-align: center;">
                                        {{ $matiere->controle ? $matiere->controle * 0.4 : '' }}
                                    </td>
                                    <td style="text-align: center;">
                                        {{ $matiere->examen ? $matiere->examen : '' }}
                                    </td>
                                    <td style="text-align: center;">
                                        {{ $matiere->examen ? $matiere->examen * 0.6 : '' }}
                                    </td>
                                    <td style="text-align: center;">
                                        {{ $matiere->examen && $matiere->controle ? $matiere->examen * 0.6 + $matiere->controle * 0.4 : '' }}
                                    </td>
                                    <td style="text-align: center;">
                                        {{ $matiere->credit_number ?? '' }}
                                    </td>

                                    @if ($matiere->examen && $matiere->controle)
                                        @php
                                            $sumAVGEcuFond += $matiere->examen * 0.6 + $matiere->controle * 0.4; // Calcul de la moyenne et ajout
                                            if ($matiere->examen * 0.6 + $matiere->controle * 0.4 > 12) {
                                                $sumCredit += $matiere->credit_number ?? 0;
                                            }
                                            $countMatieresEcuFond++; // Compter les matières avec des notes dans les écus fondamentaux
                                        @endphp
                                    @endif
                                </tr>
                            @endif
                        @endforeach

                        <tr>
                            <td style="text-align: center; font-weight:bold" colspan="6">MOYENNE ECU FONDAMENTAUX
                                (80%)
                            </td>
                            <td style="text-align: center; font-weight:bold" colspan="2">
                                {{ $sumAVGEcuFond ? number_format($sumAVGEcuFond * 0.8, 2) : '' }}
                                <!-- Calcul de la moyenne et multiplication -->
                            </td>
                        </tr>

                        <tr>
                            <td style="text-align: center; font-weight:bold" colspan="8">SEMINAIRE ET TRAVAUX
                                PRATIQUES
                            </td>
                        </tr>
                        <!-- Affichage des matières pour les séminaires et travaux pratiques -->
                        @foreach ($matieresnight as $matiere)
                            @if (strpos($matiere->matiere_name, 'Séminaire') !== false || strpos($matiere->matiere_name, 'stage') !== false)
                                <tr>
                                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                                    <td style="text-align: center;">{{ $matiere->matiere_name }}</td>
                                    <td style="text-align: center;">
                                        {{ $matiere->controle ? $matiere->controle : '' }}
                                    </td>
                                    <td style="text-align: center;">
                                        {{ $matiere->controle ? $matiere->controle * 0.4 : '' }}
                                    </td>
                                    <td style="text-align: center;">
                                        {{ $matiere->examen ? $matiere->examen : '' }}
                                    </td>
                                    <td style="text-align: center;">
                                        {{ $matiere->examen ? $matiere->examen * 0.6 : '' }}
                                    </td>
                                    <td style="text-align: center;">
                                        {{ $matiere->examen && $matiere->controle ? $matiere->examen * 0.6 + $matiere->controle * 0.4 : '' }}
                                    </td>
                                    <td style="text-align: center;">
                                        {{ $matiere->credit_number ?? '' }}
                                    </td>

                                    @if ($matiere->examen && $matiere->controle)
                                        @php
                                            $sumAVGSEM += $matiere->examen * 0.6 + $matiere->controle * 0.4; // Calcul de la moyenne et ajout
                                            if ($matiere->examen * 0.6 + $matiere->controle * 0.4 > 12) {
                                                $sumCredit += $matiere->credit_number ?? 0;
                                            }
                                            $countMatieresSeminaire++; // Compter les matières avec des notes dans les séminaires et travaux pratiques
                                        @endphp
                                    @endif
                                </tr>
                            @endif
                        @endforeach

                        <tr>
                            <td style="text-align: center; font-weight:bold" colspan="6">Moyenne Séminaire et
                                Travaux
                                Pratiques (20%)</td>
                            <td style="text-align: center; font-weight:bold" colspan="2">
                                {{ $sumAVGSEM ? number_format($sumAVGSEM * 0.2, 2) : '' }}
                                <!-- Calcul de la moyenne et multiplication -->
                            </td>
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
                                @if ($countMatieresEcuFond + $countMatieresSeminaire > 0)
                                    {{ number_format(($sumAVGEcuFond + $sumAVGSEM) / ($countMatieresEcuFond + $countMatieresSeminaire), 2) }}
                                    <!-- Division de la somme des moyennes par le nombre de matières -->
                                @else
                                    N/A
                                @endif
                            </th>
                        </tr>
                    </tfoot>
                </table>

            @endif
        @else
            @php
                $matieresday = $matieres->filter(function ($matiere) use ($getUser) {
                    return $matiere->night === 0;
                });
            @endphp
            @if (strpos($semestreObjet->name, '2') !== false ||
                    strpos($semestreObjet->name, '2 (LC)') !== false ||
                    strpos($semestreObjet->name, '2 (MA)') !== false ||
                    strpos($semestreObjet->name, '4') !== false)
                <table style="margin-left:35px">
                    <thead>
                        <tr>
                            <th style="text-align: center;" rowspan="2">N°</th>
                            <th style="text-align: center;" rowspan="2">ELEMENTS CONSTITUTIFS D'UNITES</th>
                            <th style="text-align: center;" colspan="2">CONTRÔLE CONTINU (40%)</th>
                            <th style="text-align: center;" colspan="2">EXAMENS (60%)</th>
                            <th style="text-align: center;" rowspan="2">MOY COEF /{{ $max }}</th>
                            <th style="text-align: center;" rowspan="2">CREDITS VALIDES</th>
                        </tr>
                        <tr>
                            <th style="text-align: center;">Note / {{ $max }}</th>
                            <th style="text-align: center;">Note Coéf</th>
                            <th style="text-align: center;">Note / {{ $max }}</th>
                            <th style="text-align: center;">Note Coéf</th>
                        </tr>
                    </thead>
                    @php
                        $num = 1;
                        $sumCredit = 0;
                        $sumAVGEcuFond = 0;
                        $sumAVGEcuFond = 0;
                        $countMatieresEcuFond = 0;
                        $sumAVGSEM = 0;
                        $countMatieresSeminaire = 0;
                        $countMatieresSeminaire = 0;
                    @endphp
                    <tbody>
                        <tr>
                            <td style="text-align: center; font-weight:bold" colspan="8">ECU FONDAMENTAUX</td>
                        </tr>
                        <!-- Affichage des matières pour les écus fondamentaux -->
                        @foreach ($matieresday as $matiere)
                            @if (!(strpos($matiere->matiere_name, 'Séminaire') !== false || strpos($matiere->matiere_name, 'stage') !== false))
                                <tr>
                                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                                    <td style="text-align: center;">{{ $matiere->matiere_name }}</td>
                                    <td style="text-align: center;">
                                        {{ $matiere->controle ? $matiere->controle : '' }}
                                    </td>
                                    <td style="text-align: center;">
                                        {{ $matiere->controle ? $matiere->controle * 0.4 : '' }}
                                    </td>
                                    <td style="text-align: center;">
                                        {{ $matiere->examen ? $matiere->examen : '' }}
                                    </td>
                                    <td style="text-align: center;">
                                        {{ $matiere->examen ? $matiere->examen * 0.6 : '' }}
                                    </td>
                                    <td style="text-align: center;">
                                        {{ $matiere->examen && $matiere->controle ? $matiere->examen * 0.6 + $matiere->controle * 0.4 : '' }}
                                    </td>
                                    <td style="text-align: center;">
                                        {{ $matiere->credit_number ?? '' }}
                                    </td>

                                    @if ($matiere->examen && $matiere->controle)
                                        @php
                                            $sumAVGEcuFond += $matiere->examen * 0.6 + $matiere->controle * 0.4; // Calcul de la moyenne et ajout
                                            if ($matiere->examen * 0.6 + $matiere->controle * 0.4 > 12) {
                                                $sumCredit += $matiere->credit_number ?? 0;
                                            }
                                            $countMatieresEcuFond++; // Compter les matières avec des notes dans les écus fondamentaux
                                        @endphp
                                    @endif
                                </tr>
                            @endif
                        @endforeach

                        <tr>
                            <td style="text-align: center; font-weight:bold" colspan="6">MOYENNE ECU FONDAMENTAUX
                                (80%)
                            </td>
                            <td style="text-align: center; font-weight:bold" colspan="2">
                                {{ $sumAVGEcuFond ? number_format($sumAVGEcuFond * 0.8, 2) : '' }}
                                <!-- Calcul de la moyenne et multiplication -->
                            </td>
                        </tr>

                        <tr>
                            <td style="text-align: center; font-weight:bold" colspan="8">SEMINAIRE ET TRAVAUX
                                PRATIQUES
                            </td>
                        </tr>
                        <!-- Affichage des matières pour les séminaires et travaux pratiques -->
                        @foreach ($matieresday as $matiere)
                            @if (strpos($matiere->matiere_name, 'Séminaire') !== false || strpos($matiere->matiere_name, 'stage') !== false)
                                <tr>
                                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                                    <td style="text-align: center;">{{ $matiere->matiere_name }}</td>
                                    <td style="text-align: center;">
                                        {{ $matiere->controle ? $matiere->controle : '' }}
                                    </td>
                                    <td style="text-align: center;">
                                        {{ $matiere->controle ? $matiere->controle * 0.4 : '' }}
                                    </td>
                                    <td style="text-align: center;">
                                        {{ $matiere->examen ? $matiere->examen : '' }}
                                    </td>
                                    <td style="text-align: center;">
                                        {{ $matiere->examen ? $matiere->examen * 0.6 : '' }}
                                    </td>
                                    <td style="text-align: center;">
                                        {{ $matiere->examen && $matiere->controle ? $matiere->examen * 0.6 + $matiere->controle * 0.4 : '' }}
                                    </td>
                                    <td style="text-align: center;">
                                        {{ $matiere->credit_number ?? '' }}
                                    </td>

                                    @if ($matiere->examen && $matiere->controle)
                                        @php
                                            $sumAVGSEM += $matiere->examen * 0.6 + $matiere->controle * 0.4; // Calcul de la moyenne et ajout
                                            if ($matiere->examen * 0.6 + $matiere->controle * 0.4 > 12) {
                                                $sumCredit += $matiere->credit_number ?? 0;
                                            }
                                            $countMatieresSeminaire++; // Compter les matières avec des notes dans les séminaires et travaux pratiques
                                        @endphp
                                    @endif
                                </tr>
                            @endif
                        @endforeach

                        <tr>
                            <td style="text-align: center; font-weight:bold" colspan="6">Moyenne Séminaire et
                                Travaux
                                Pratiques (20%)</td>
                            <td style="text-align: center; font-weight:bold" colspan="2">
                                {{ $sumAVGSEM ? number_format($sumAVGSEM * 0.2, 2) : '' }}
                                <!-- Calcul de la moyenne et multiplication -->
                            </td>
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
                                @if ($countMatieresEcuFond + $countMatieresSeminaire > 0)
                                    {{ number_format(($sumAVGEcuFond + $sumAVGSEM) / ($countMatieresEcuFond + $countMatieresSeminaire), 2) }}
                                    <!-- Division de la somme des moyennes par le nombre de matières -->
                                @else
                                    N/A
                                @endif
                            </th>
                        </tr>
                    </tfoot>
                </table>

            @endif
        @endif



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
