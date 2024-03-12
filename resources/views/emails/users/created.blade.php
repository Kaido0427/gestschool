<!DOCTYPE html>
<html>
<head>
    <title>Institut Jean Paul 2</title>
</head>
<body>
    <h1>Bonjour {{ $data['name']  }} {{ $data['firstname'] }}</h1>
    <p> Un compte a été créé pour vous sur le site {{ env('APP_URL')}}</p>
    
    <p> Vos identifiant de connexion sont: </p>
    <p> Email: {{ $data['email']}} </p>
    <p> Mot de passe: Etudi@nt </p>
    <p> Url de connexion: <a href="https://monespace.institutjeanpaul2.org/student-login"> LIEN</a> </p>
   
    <p>Merci</p>
</body>
</html>