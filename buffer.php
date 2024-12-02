<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revelium Present</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="nav">
	<div class="dropdown">
		<button class="dropbtn">GÜELCOM</button>
		<div class="dropdown-content">
			<a href="index.php">Inicio</a><br>
			<a href="profile.php">Perfil</a><br>
			<a href="buffer.php">Ir a clase</a>
		</div>
	</div>
	</div>
	</body>
</html>
<?php
session_start();
$type = $_SESSION['type'];
if ($type == 'student'){
	header('location: send_code.php');
} elseif ($type == 'teacher') {
	header('location: get_subjects.php');
} else {
	die("Trip to the world <br>Yo! here we go unknown world e to <br>uma reta bakari no tabibito <br>Narenai ashidori mo mata aikyou <br>kimeru toko dake bashitto! <br>So many people in this world toki ni <br>chuushou tokamonai wake ja nai kedo <br>Tsuman'nai toko wa warp shite kou <br>suji dake wa toushi ikiteru That's our law!");
}
?>