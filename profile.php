<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfilazo</title>
	<link rel="stylesheet" href="styles.css">
</head>
<?php
$words= ['crack','maestro','guerrero','mastodonte','bestia','caballero de la noche','fiera','masterclass','relámpago','locura','Big Boss'];
$word= array_rand($words);
$randomword= $words[$word];
session_start();
if (isset ($_SESSION['id'])){
	echo "Hola ".$_SESSION['name'].' '.$_SESSION['surname'].".<br> Cómo te va $randomword?<br><br>".htmlspecialchars($_SESSION['mail']);
}else{
	echo "No iniciaste sesion $randomword. Iniciala o registrate.";
}
?>
<body>
<div class="nav">
	<div class="dropdown">
		<button class="dropbtn">Perfilazo</button>
		<div class="dropdown-content">
			<a href="index.php">Inicio</a><br>
			<a href="profile.php">Perfil</a><br>
			<a href="buffer.php">Ir a clase</a>
		</div>
	</div>
	</div>
    <div class="container">
        <br><button onclick="location.href='login.html'">Iniciar sesión</button><br>
        <button onclick="location.href='registrarse.html'">Registrar usuario</button><br>
        <br><button onclick="location.href='killuser.php'">Mortadelear a alguien >:)</button>
    </div>
</body>
</html>