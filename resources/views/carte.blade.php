<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <title>Carte Face </title>
    <style>
        body {
            margin: 0 auto;
            /*color:rgb(211, 34, 79);*/
        }

        h3 {
            padding-left: 110px;
        }

        #logojp {
            width: 150px;
            height: 150px;
        }

        .tab {
            font-weight: 900;
        }

        #vertical {
            border-left: 2px black solid;
            padding-left: 20px;
            padding-top: 20px;
        }

        #year {
            background-color: rgb(8, 8, 92);
            color: azure;
            height: 25px;
        }

        #pict {
            height: 100px;
            width: 100px;
        }

        #section2 {
            margin-top: 30px;
        }

        #bordrad {
            border: 3px black solid;
            border-radius: 10px;
            /* width:20px; */
            color: black;
            margin-left: 20px;
        }

        #imgqr {
            padding-left: 20px;
            padding-right: 20px;
            width: 100px;
        }

        #body {
            width: 500px;
            margin: 0 auto;
            background: linear-gradient(90deg, rgba(211, 217, 215, 0.24768518518518523) 13%, rgba(255, 255, 255, 0.23842592592592593) 51%, rgba(223, 220, 220, 0.20833333333333337) 99%);
            background-image: url({{ public_path('images/thumbnail/aperçu.png') }});
            background-size: cover;
            background-repeat: no-repeat;
            margin-bottom: 20px;
        }

        p {
            color: black;
        }

        .bas {
            margin: 5%;
            margin-bottom: 30px;
            font-weight: 600;
        }

        #text {
            padding-left: 10px;
            font-weight: 600;
        }

        .wrapper {
            margin-bottom: 20px;
        }
    </style>
</head>

<body style="width: 490px">
    <div>
        <table>
            <tr>
                <td>
                    <div id="visa">
                        <img id="logojp" src="{{ public_path('dist/img/logo.png') }}" alt="" /><br />
                        <img id="logojp" src="{{ public_path('images/thumbnail/' . $student->avatar['url']) }}"
                            alt="" />
                    </div>
                </td>
                <td>
                    <div id="form">
                        <h2>CARTE D'ETUDIANT</h2>
                        <br />
                        <div id="vertical">
                            <table>
                                <tr>
                                    <td>NOM</td>
                                    <td class="tab">
                                        {{ $student->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <hr />
                                    </td>
                                </tr>
                                <tr>
                                    <td>PRENOM</td>
                                    <td class="tab">{{ $student->firstname }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2"> 
                                        <hr />
                                    </td>
                                </tr>
                                <tr>
                                    <td>FILIERE</td>
                                    <td class="tab">
                                        
                                        {{ $sector->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <hr />
                                    </td>
                                </tr>
                                <tr>
                                    <td>NUMERO MATRICULE</td>
                                    <td class="tab">&nbsp; &nbsp; &nbsp;{{ $student->matricule }}</td>
                                </tr>
                            </table>
                            <hr />
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <h3 id="year">ANNEE ACADEMIQUE: {{$student->promotion->name}}</h3>
    <hr>
    <div id="body" style="margin-top: 100px">
        <div id="pict">
            <img src="{{ public_path('dist/img/logo.png') }}" alt="" id="pict" />
        </div>
        <br />
        <div class="wrapper">
            <div id="section2">
                <table>
                    <tr>
                        <td>
                            <div id="bordrad">
                                <p id="text">
                                    Adre Cadjèhoun (Cotonou), entre le codiam et le Collège Père
                                    AUPIAIS <br />
                                    Adresse postale <br />
                                    04 BP1217 Cotonou (Bénin)
                                </p>
                            </div>
                        </td>
                        <td>
                            <div>
                                <img src="data:image/png;base64, {!! base64_encode(QrCode::size(100)->generate($url)) !!}  " class="dg-signature-logo">
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="bas">
            <p>En cas de perte ou de découverte, merci de prévenir la direction</p>
        </div>
    </div>
</body>

</html>
