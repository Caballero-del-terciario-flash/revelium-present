<html lang="en">
<head>
    <title>Mortadeleado</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="nav">
	<div class="dropdown">
		<button class="dropbtn">Registreited</button>
		<div class="dropdown-content">
			<a href="index.php">Inicio</a><br>
			<a href="profile.php">Perfil</a><br>
			<a href="buffer.php">Ir a clase</a>
		</div>
	</div>
	</div>
<?php
$words= ['crack','maestro','guerrero','mastodonte','bestia','caballero de la noche','fiera','masterclass','relámpago','locura','Big Boss'];
$word= array_rand($words);
$randomword= $words[$word];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $DNI = $_POST['dni'];
    $mail = $_POST['mail'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $type = $_POST['type'];

    if ($password !== $confirm_password) {
        echo "Las contraseñas no coinciden.";
        exit;
    }

    $host = 'localhost';
    $usuario = 'root';
    $clave = '';
    $base_de_datos = 'revelium_present';

    $conn = new mysqli($host, $usuario, $clave, $base_de_datos);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    if ($type == 'teacher') {
        $sql = "INSERT INTO teachers (name, surname, DNI, mail, password) 
                VALUES ('$name', '$surname', '$DNI', '$mail', '$hashed_password')";
    } elseif ($type == 'student') {
        $career = $_POST['career'];
        $year = $_POST['year'];
        $sql = "INSERT INTO students (name, surname, DNI, mail, password, career, year) 
                VALUES ('$name', '$surname', '$DNI', '$mail', '$hashed_password', '$career', '$year')";
    } else {
        echo "tipo de cuenta no válido.";
        exit;
    }

    if ($conn->query($sql) == TRUE) {
        echo "Cuenta registrada $randomword. Que tengas un excelente día.";
    } else {
        echo "No se pudo hacer $randomword: " . $conn->error;
    }

    $conn->close();
}
?>
</body>
</html>