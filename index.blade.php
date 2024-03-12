@extends('layouts.app')

@section('title', 'Statistique')
@section('content')
    <style>
        .centered-cell {
            text-align: center;
            vertical-align: middle;
        }
    </style>
    <section class="content">
        <h1 class="text-center text-uppercase font-weight-bold">TABLEAU SYNOPTIQUE UE-ECU-ENSEIGNANTS</h1>

        <div class="card-header">

            <ul class="nav nav-tabs" id="semesterTabs">
                <li class="nav-item">
                    <a class="nav-link active" id="semester1-tab" data-toggle="tab" href="#licence1_2">Licence(I & II) </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" id="semestre5_6-tab" data-toggle="tab" href="#licences5s6">Licence(III)</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="licence-canonique-tab" data-toggle="tab" href="#lcanonique">Licence
                        Canonique</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="master" data-toggle="tab" href="#masters">Master</a>
                </li>
            </ul>
        </div>
        <div class="tab-content mt-2">
            <!--   SECTION LICENCE I & II-->

            <div class="tab-pane fade show active" id="licence1_2">
                @if (count($semestreWithMatieresL1L2))

                    <table class="table" border="1">
                        <thead>
                            <tr>
                                <th>CODES</th>
                                <th>UE</th>
                                <th>ECU</th>
                                <th>Enseignant</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($semestreWithMatieresL1L2 as $semestre)
                                @if (count($semestre['ues']))
                                    <!-- Afficher le nom du semestre -->
                                    <tr>
                                        <td colspan="4" class="text-center text-red text-uppercase font-weight-bold">
                                            {{ $semestre->name }}
                                        </td>
                                    </tr>

                                    <!-- Regrouper les UE par type d'UE -->
                                    @php
                                        $uesByType = $semestre['ues']->groupBy('type');
                                    @endphp

                                    <!-- Parcourir les types d'UE -->
                                    @foreach ($uesByType as $type => $ues)
                                        <!-- Afficher le titre de l'UE -->
                                        <tr>
                                            <td colspan="4" class="text-center text-red text-uppercase font-weight-bold">
                                                {{ $type }}
                                            </td>
                                        </tr>

                                        <!-- Parcourir les UE -->
                                        @foreach ($ues as $index => $ue)
                                            <!-- Parcourir les matières de cette UE -->
                                            @foreach ($ue->matieres as $indexMat => $matiere)
                                                <tr>
                                                    <!-- Afficher le code et le nom de l'UE uniquement pour la première matière -->
                                                    @if ($indexMat == 0)
                                                        <td rowspan="{{ count($ue->matieres) }}" class="centered-cell">
                                                            {{ $ue->code }}</td>
                                                        <td rowspan="{{ count($ue->matieres) }}" class="centered-cell">
                                                            {{ $ue->name }}</td>
                                                    @endif

                                                    <!-- Afficher le nom de la matière -->
                                                    <td class="centered-cell">{{ $matiere->name }}</td>

                                                    <!-- Afficher les professeurs associés à la matière -->
                                                    <td class="centered-cell">
                                                        @if ($matiere->classMatieres->isNotEmpty())
                                                            @foreach ($matiere->classMatieres as $classMatiere)
                                                                @if ($classMatiere->teachersThroughMatiereTeacher->isNotEmpty())
                                                                    @foreach ($classMatiere->teachersThroughMatiereTeacher as $teacher)
                                                                        {{ $teacher->name }}
                                                                        {{ $teacher->firstname }}<br>
                                                                    @endforeach
                                                                @else
                                                                    Aucun professeur n'est affecté à cette matière dans
                                                                    cette classe !
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            Aucune classe n'est associée à cette matière !
                                                        @endif


                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                @endif
                            @endforeach

                        </tbody>
                    </table>
                @else
                    <p class="text-center text-uppercase text-danger font-weight-bold"> Rien à afficher </p>

                @endif
            </div>

            <!--   SECTION LICENCE III-->

            <div class="tab-pane fade" id="licences5s6">
                @if (count($semestreWithMatieresL3))

                    <table class="table" border="1">
                        <thead>
                            <tr>
                                <th>CODES</th>
                                <th>UE</th>
                                <th>ECU</th>
                                <th>Enseignant</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($semestreWithMatieresL3 as $semestre)
                                @if (count($semestre['ues']))
                                    <!-- Afficher le nom du semestre -->
                                    <tr>
                                        <td colspan="4" class="text-center text-red text-uppercase font-weight-bold">
                                            {{ $semestre->name }}
                                        </td>
                                    </tr>

                                    <!-- Regrouper les UE par type d'UE -->
                                    @php
                                        $uesByType = $semestre['ues']->groupBy('type');
                                    @endphp

                                    <!-- Parcourir les types d'UE -->
                                    @foreach ($uesByType as $type => $ues)
                                        <!-- Afficher le titre de l'UE -->
                                        <tr>
                                            <td colspan="4" class="text-center text-red text-uppercase font-weight-bold">
                                                {{ $type }}
                                            </td>
                                        </tr>

                                        <!-- Parcourir les UE -->
                                        @foreach ($ues as $index => $ue)
                                            <!-- Parcourir les matières de cette UE -->
                                            @foreach ($ue->matieres as $indexMat => $matiere)
                                                <tr>
                                                    <!-- Afficher le code et le nom de l'UE uniquement pour la première matière -->
                                                    @if ($indexMat == 0)
                                                        <td rowspan="{{ count($ue->matieres) }}" class="centered-cell">
                                                            {{ $ue->code }}</td>
                                                        <td rowspan="{{ count($ue->matieres) }}" class="centered-cell">
                                                            {{ $ue->name }}</td>
                                                    @endif

                                                    <!-- Afficher le nom de la matière -->
                                                    <td class="centered-cell">{{ $matiere->name }}</td>

                                                    <!-- Afficher les professeurs associés à la matière -->
                                                    <td class="centered-cell">
                                                        @if ($matiere->classMatieres->isNotEmpty())
                                                            @foreach ($matiere->classMatieres as $classMatiere)
                                                                @if ($classMatiere->teachersThroughMatiereTeacher->isNotEmpty())
                                                                    @foreach ($classMatiere->teachersThroughMatiereTeacher as $teacher)
                                                                        {{ $teacher->name }}
                                                                        {{ $teacher->firstname }}<br>
                                                                    @endforeach
                                                                @else
                                                                    Aucun professeur n'est affecté à cette matière dans
                                                                    cette classe !
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            Aucune classe n'est associée à cette matière !
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-center text-uppercase text-danger font-weight-bold"> Rien à afficher </p>

                @endif
            </div>

            <!--   SECTION LICENCE CANONIQUE-->
            <div class="tab-pane fade" id="lcanonique">
                @if (count($semestreWithMatieresLcano))

                    <table class="table" border="1">
                        <thead>
                            <tr>
                                <th>CODES</th>
                                <th>UE</th>
                                <th>ECU</th>
                                <th>Enseignant</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($semestreWithMatieresLcano as $semestre)
                                @if (count($semestre['ues']))
                                    <!-- Afficher le nom du semestre -->
                                    <tr>
                                        <td colspan="4" class="text-center text-red text-uppercase font-weight-bold">
                                            {{ $semestre->name }}
                                        </td>
                                    </tr>

                                    <!-- Regrouper les UE par type d'UE -->
                                    @php
                                        $uesByType = $semestre['ues']->groupBy('type');
                                    @endphp

                                    <!-- Parcourir les types d'UE -->
                                    @foreach ($uesByType as $type => $ues)
                                        <!-- Afficher le titre de l'UE -->
                                        <tr>
                                            <td colspan="4" class="text-center text-red text-uppercase font-weight-bold">
                                                {{ $type }}
                                            </td>
                                        </tr>

                                        <!-- Parcourir les UE -->
                                        @foreach ($ues as $index => $ue)
                                            <!-- Parcourir les matières de cette UE -->
                                            @foreach ($ue->matieres as $indexMat => $matiere)
                                                <tr>
                                                    <!-- Afficher le code et le nom de l'UE uniquement pour la première matière -->
                                                    @if ($indexMat == 0)
                                                        <td rowspan="{{ count($ue->matieres) }}" class="centered-cell">
                                                            {{ $ue->code }}</td>
                                                        <td rowspan="{{ count($ue->matieres) }}" class="centered-cell">
                                                            {{ $ue->name }}</td>
                                                    @endif

                                                    <!-- Afficher le nom de la matière -->
                                                    <td class="centered-cell">{{ $matiere->name }}</td>

                                                    <!-- Afficher les professeurs associés à la matière -->
                                                    <td class="centered-cell">
                                                        @if ($matiere->classMatieres->isNotEmpty())
                                                            @foreach ($matiere->classMatieres as $classMatiere)
                                                                @if ($classMatiere->teachersThroughMatiereTeacher->isNotEmpty())
                                                                    @foreach ($classMatiere->teachersThroughMatiereTeacher as $teacher)
                                                                        {{ $teacher->name }}
                                                                        {{ $teacher->firstname }}<br>
                                                                    @endforeach
                                                                @else
                                                                    Aucun professeur n'est affecté à cette matière dans
                                                                    cette classe !
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            Aucune classe n'est associée à cette matière !
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                @endif
                            @endforeach

                        </tbody>
                    </table>
                @else
                    <p class="text-center text-uppercase text-danger font-weight-bold"> Rien à afficher </p>

                @endif
            </div>

            <!--   SECTION MASTER-->

            <div class="tab-pane fade" id="masters">
                @if (count($semestreWithMatieresMastere))

                    <table class="table" border="1">
                        <thead>
                            <tr>
                                <th>CODES</th>
                                <th>UE</th>
                                <th>ECU</th>
                                <th>Enseignant</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($semestreWithMatieresMastere as $semestre)
                                @if (count($semestre['ues']))
                                    <!-- Afficher le nom du semestre -->
                                    <tr>
                                        <td colspan="4" class="text-center text-red text-uppercase font-weight-bold">
                                            {{ $semestre->name }}
                                        </td>
                                    </tr>

                                    <!-- Regrouper les UE par type d'UE -->
                                    @php
                                        $uesByType = $semestre['ues']->groupBy('type');
                                    @endphp

                                    <!-- Parcourir les types d'UE -->
                                    @foreach ($uesByType as $type => $ues)
                                        <!-- Afficher le titre de l'UE -->
                                        <tr>
                                            <td colspan="4" class="text-center text-red text-uppercase font-weight-bold">
                                                {{ $type }}
                                            </td>
                                        </tr>

                                        <!-- Parcourir les UE -->
                                        @foreach ($ues as $index => $ue)
                                            <!-- Parcourir les matières de cette UE -->
                                            @foreach ($ue->matieres as $indexMat => $matiere)
                                                <tr>
                                                    <!-- Afficher le code et le nom de l'UE uniquement pour la première matière -->
                                                    @if ($indexMat == 0)
                                                        <td rowspan="{{ count($ue->matieres) }}" class="centered-cell">
                                                            {{ $ue->code }}</td>
                                                        <td rowspan="{{ count($ue->matieres) }}" class="centered-cell">
                                                            {{ $ue->name }}</td>
                                                    @endif

                                                    <!-- Afficher le nom de la matière -->
                                                    <td class="centered-cell">{{ $matiere->name }}</td>

                                                    <!-- Afficher les professeurs associés à la matière -->
                                                    <td class="centered-cell">
                                                        @if ($matiere->classMatieres->isNotEmpty())
                                                            @foreach ($matiere->classMatieres as $classMatiere)
                                                                @if ($classMatiere->teachersThroughMatiereTeacher->isNotEmpty())
                                                                    @foreach ($classMatiere->teachersThroughMatiereTeacher as $teacher)
                                                                        {{ $teacher->name }}
                                                                        {{ $teacher->firstname }}<br>
                                                                    @endforeach
                                                                @else
                                                                    Aucun professeur n'est affecté à cette matière dans
                                                                    cette classe !
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            Aucune classe n'est associée à cette matière !
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                @endif
                            @endforeach


                        </tbody>
                    </table>
                @else
                    <p class="text-center text-uppercase text-danger font-weight-bold"> Rien à afficher </p>
                @endif
            </div>


        </div>

    </section>

@stop
