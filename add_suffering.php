<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materia Agregueitor</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="nav">
	<div class="dropdown">
		<button class="dropbtn">Materia Agregada</button>
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
// Conectar a la base de datos
$servername = "localhost";
$username = "usuario";
$password = "contraseña";
$dbname = "name_base_datos";

$conn = new mysqli($servername, $username, $password, $dbname);
$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
	$mail = $_POST['mail'];
	$year = $_POST['year'];
	$career = $_POST['career'];
	
    $sql = "SELECT id FROM profesores WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $mail, PDO::PARAM_STR);
    $stmt->execute();

	$id = $stmt->fetchColumn();

    // Insertar la nueva materia en la base de datos
    $sql = "INSERT INTO subject (subject_name, teacher_id, year, career) VALUES ($name, $id, $year, $career)";
    
    if ($conn->query($sql) === TRUE) {
        echo "Materia agregada correctamente. Dudas? Preguntas?";
    } else {
        echo "Baka Mitai: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>