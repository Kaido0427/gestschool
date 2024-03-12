<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <title>
        @if ($student->student->gender == 'M')
            CARTE DE L'ETUDIANT
        @else
            CARTE DE L'ETUDIANTE
        @endif
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            margin: 0;
            font-size: 9px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        #container {
            width: 9cm;
            height: 7cm;
            margin: 0 auto;
            padding: 0.5cm;
            background-size: cover;
            background-repeat: no-repeat;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: space-between;

        }

        h2 {
            text-align: center;
            background-color: rgb(8, 8, 92);
            color: azure;
            padding: 5px;
            margin: 0;
            font-size: 9px;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }

        h3 {
            text-align: center;
            background-color: rgb(8, 8, 92);
            color: azure;
            padding: 5px;
            margin: 0;
            font-size: 9px;
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
            /* Ajustement de la taille du texte */
        }



        table {
            width: 100%;
            margin: 0;
            border-collapse: collapse;
        }

        td {
            font-size: 8px;
        }


        th {
            padding: 2px;
            border: none;
            text-align: center;
            font-size: 9px;
            /* Ajustement de la taille du texte */
        }

        .visa-container {
            width: 100%;
        }

        .visa {
            width: 35%;
            padding: 3px;

        }

        .form {
            width: 65%;
            /* Chaque colonne prendra la moitié de la largeur */
            vertical-align: top;
            /* Alignement vertical en haut */
            padding: 5px;
            /* Espace intérieur */
        }

        .visa .image-container {
            height: 200px;
            /* Ajustez la hauteur selon vos besoins */
            position: relative;
            /* Assurez-vous que les images à l'intérieur restent positionnées correctement */
        }

        .visa img {
            width: 100%;
            height: auto;
            border-radius: 2%;
            max-width: 100%;
            position: absolute;
            /* Position absolue pour que les images restent superposées */
            top: 0;
            /* Alignez les images en haut du conteneur */
            left: 0;
            /* Alignez les images à gauche du conteneur */
        }

        .visa .logo {
            z-index: 1;
            /* Assurez-vous que le logo est au-dessus de l'autre image */
        }

        .form table {
            width: 100%;
        }

        .tab {
            font-weight: bold;
        }


        #vertical {
            border-left: 2px black solid;
            padding-left: 5px;
            /* Réduire le padding */
            padding-top: 10px;
            /* Réduire le padding */
            font-size: 5px;
            /* Ajuster la taille du texte */
        }


        #bordrad {
            text-align: center;
            border: 3px black solid;
            border-radius: 10px;
            padding: 3px;
            margin: 5px;
            /* Réduire la marge */
            font-size: 9px;
            /* Ajustement de la taille du texte */
        }

        #signature {
            display: flex;
            justify-content: space-between;
            padding-bottom: 10px;
        }

        #pict {
            text-align: center;
            margin-top: 5px;
            /* Réduire l'espace en haut */
            margin-bottom: 5px;
            /* Ajouter un espace en bas */
        }

        #pict img {
            max-width: 100%;
            height: auto;
        }

        #pictTop img {
            max-width: 100%;
            height: auto;
        }

        .bas {
            margin: 1%;
            margin-bottom: 10px;
            /* Réduire la marge en bas */
            font-weight: 600;
            text-align: center;
            font-size: 9px;
            /* Ajustement de la taille du texte */
        }

        .bas p {
            text-align: center;
            background-color: rgb(184, 28, 28);
            color: azure;
            padding: 5px;
            margin: 0;
            font-size: 9px;
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
        }

        #signature {
            display: flex;

            /* Aligner les éléments sur la ligne de base */
            justify-content: space-between;
            padding-bottom: 10px;
        }

        .vicePresident {
            font-size: 9px;
            margin: 0;
            text-align: right;
            padding: 0;
        }

        .signatureEtudiant {
            font-size: 9px;
            margin: 0;
            text-align: left;
            padding: 0;
            margin-top: 12px;


        }


        @media screen and (max-width: 768px) {
            .form {
                padding-left: 2px;
                font-size: 7px;
            }

            #vertical {
                padding-top: 10px;
            }

            #bordrad {
                padding: 2px;
                margin: 5px;
                font-size: 7px;
                /* Ajustement de la taille du texte */
            }

            #signature {
                height: 0.2cm;
            }

            .bas {
                margin: 0.5%;
                margin-bottom: 2px;
                font-size: 7px;
                margin-top: 45px;
                /* Ajustement de la taille du texte */
            }

        }
    </style>
</head>

<body>
    <div id="container">
        @if ($student->student->gender == 'M')
            <h2>CARTE DE L'ETUDIANT</h2>
        @else
            <h2>CARTE DE L'ETUDIANTE</h2>
        @endif


        <table class="visa-container">
            <tr>
                <td class="visa">
                    <div class="image-container">
                        <img class="logo" src="{{ asset('dist/img/entete.jpg') }}" alt="" />
                        @if ($image)
                            <img style="padding-top: 50px;" src="{{ asset('images/thumbnail/' . $image->url) }}"
                                alt="" />
                        @endif
                    </div>
                </td>
                <td class="form">
                    <div id="vertical">
                        <table>
                            <tr>
                                <td>NOM :</td>
                                <td class="tab">{{ $student->student->name }}</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <hr />
                                </td>
                            </tr>
                            <tr>
                                <td>PRENOMS :</td>
                                <td class="tab">{{ $student->student->firstname }}</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <hr />
                                </td>
                            </tr>
                            <tr>
                                @if ($student->student->gender == 'M')
                                    <td>NE LE:</td>
                                @else
                                    <td>NEE LE:</td>
                                @endif
                                <td class="tab">{{ date('d/m/Y', strtotime($student->student->birth_day)) }}
                                </td>

                            </tr>
                            <tr>
                                <td colspan="2">
                                    <hr />
                                </td>
                            </tr>
                            <tr>
                                <td>A :</td>
                                <td class="tab">{{ $student->student->birth_place }}</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <hr />
                                </td>
                            </tr>
                            <tr>
                                <td>CURSUS :</td>
                                <td class="tab">{{ $student->mclass->level->name }}</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <hr />
                                </td>
                            </tr>
                            <tr>
                                <td>FILIERE :</td>
                                <td class="tab">{{ $sector->name }}</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <hr />
                                </td>
                            </tr>
                            <tr>
                                <td> MATRICULE :</td>
                                <td class="tab">&nbsp; &nbsp; &nbsp;{{ $student->student->matricule }}</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <hr />
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>

        <div id="signature">
            @if ($student->student->gender == 'M')
                <p class="signatureEtudiant">Signature de l'Etudiant</p>
            @else
                <p class="signatureEtudiant">Signature de l'Etudiante</p>
            @endif

            <p class="vicePresident">Président</p>
        </div>
        <hr />

        <h3>ANNEE ACADEMIQUE: {{ $student->promotion->name }}</h3>

        <div id="body">
            <hr />
            <div id="pict">
                <img src="{{ asset('dist/img/entetebas.jpg') }}" alt="" />
            </div>
            <div class="wrapper">
                <div id="section2">
                    <table>
                        <tr>
                            <td>
                                <div id="bordrad">
                                    <p>Cadjèhoun (Cotonou),Tél: <strong>+229 99521313</strong> / <strong>+299
                                            99521414</strong> <br>
                                        Email: <strong>jpacademie@yahoo.fr</strong> <br>
                                        Sise Entre le Codiam et le Collège Père AUPIAIS <br>
                                        Adresse postale : 04 BP1217 Cotonou (Bénin)
                                    </p>
                                </div>
                            </td>
                            <td></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="bas">
                <p>En cas de perte ou de découverte, merci de prévenir la direction</p>
            </div>
        </div>
    </div>
</body>

</html>
