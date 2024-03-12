@extends('layouts.app')

@section('title', 'Statistique')
@section('content')
    <section class="content">
        <h1 class="text-center text-uppercase font-weight-bold">TABLEAU SYNOPTIQUE UE-ECU-ENSEIGNANTS-CLASSES</h1>
        <div class="tab-content mt-2">
            <div class="tab-pane fade show active" id="licence1_2">
               

                @if (count($semestreWithMatieres) && count($semestreWithMatieres[0]['ues']))

                    <table class="table" border="1">
                        <thead>
                            <tr>
                                <th>CODES</th>
                                <th>UE</th>
                                <th>ECU</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($semestreWithMatieres as $semestre)
                                @if (count($semestre['ues']))
                                    <tr>
                                        <td colspan="4" class="text-center text-red text-uppercase font-weight-bold">

                                            {{ $semestre->name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-center text-red text-uppercase font-weight-bold">
                                            UE DE CONNAISSANCES FONDAMENTALES

                                        </td>
                                    </tr>

                                    @foreach ($semestre['ues'] as $ues)
                                        @if ($ues->type === 'UE DE CONNAISSANCES FONDAMENTALES')
                                            <tr>
                                                <td>{{ $ues->code }}</td>
                                                <td>{{ $ues->name }}</td>
                                                <td>
                                                    <ul>
                                                        @foreach ($ues->matieres as $matiere)
                                                            <li>{{ $matiere->name }}</li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                             
                                            </tr>
                                        @endif
                                    @endforeach

                                    <tr>
                                        <td colspan="4" class="text-center text-red text-uppercase font-weight-bold">
                                            UE DE SPECIALITE
                                        </td>
                                    </tr>
                                    @foreach ($semestre['ues'] as $ues)
                                        @if ($ues->type === 'UE DE SPECIALITE')
                                            <tr>
                                                <td>{{ $ues->code }}</td>
                                                <td>{{ $ues->name }}</td>
                                                <td>
                                                    <ul>
                                                        @foreach ($ues->matieres as $matiere)
                                                            <li>{{ $matiere->name }}</li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                          
                                            </tr>
                                        @endif
                                    @endforeach

                                    <tr>
                                        <td colspan="4" class="text-center text-red text-uppercase font-weight-bold">
                                            UE DE METHODOLOGIE
                                        </td>
                                    </tr>
                                    @foreach ($semestre['ues'] as $ues)
                                        @if ($ues->type === 'UE DE METHODOLOGIE')
                                            <tr>
                                                <td>{{ $ues->code }}</td>
                                                <td>{{ $ues->name }}</td>
                                                <td>
                                                    <ul>
                                                        @foreach ($ues->matieres as $matiere)
                                                            <li>{{ $matiere->name }}</li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                            
                                            </tr>
                                        @endif
                                    @endforeach

                                    <tr>
                                        <td colspan="4" class="text-center text-red text-uppercase font-weight-bold">
                                            UE CULTURE GÉNÉRALE
                                        </td>
                                    </tr>
                                    @foreach ($semestre['ues'] as $ues)
                                        @if ($ues->type === 'UE CULTURE GÉNÉRALE')
                                            <tr>
                                                <td>{{ $ues->code }}</td>
                                                <td>{{ $ues->name }}</td>
                                                <td>
                                                    <ul>
                                                        @foreach ($ues->matieres as $matiere)
                                                            <li>{{ $matiere->name }}</li>
                                                        @endforeach
                                                    </ul>
                                                </td>
            
                                            </tr>
                                        @endif
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
