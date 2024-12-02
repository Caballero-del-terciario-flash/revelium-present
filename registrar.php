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
// Procesar el formulario de registro
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibir los datos del formulario
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $DNI = $_POST['dni'];
    $mail = $_POST['mail'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $type = $_POST['type']; // type de cuenta: 'profesor', 'estudiante'

    // Validar que las contraseñas coinciden
    if ($password !== $confirm_password) {
        echo "Las contraseñas no coinciden.";
        exit;
    }

    // Conexión a la base de datos
    $host = 'localhost'; // o el host de tu base de datos
    $usuario = 'root'; // tu usuario de base de datos
    $clave = ''; // tu clave de base de datos
    $base_de_datos = 'revelium_present'; // el name de tu base de datos

    $conn = new mysqli($host, $usuario, $clave, $base_de_datos);

    // Comprobar si la conexión fue exitosa
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Encriptar la contraseña antes de guardarla
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Determinar la table y los campos según el type de cuenta
    if ($type == 'teacher') {
        // Insertar en la table "profesores"
        $sql = "INSERT INTO teachers (name, surname, DNI, mail, password) 
                VALUES ('$name', '$surname', '$DNI', '$mail', '$hashed_password')";
    } elseif ($type == 'student') {
        // Insertar en la table "estudiantes"
        $career = $_POST['career'];
        $year = $_POST['year'];
        $sql = "INSERT INTO students (name, surname, DNI, mail, password, career, year) 
                VALUES ('$name', '$surname', '$DNI', '$mail', '$hashed_password', '$career', '$year')";
    } else {
        echo "tipo de cuenta no válido.";
        exit;
    }

    // Ejecutar la consulta
    if ($conn->query($sql) == TRUE) {
        echo "Cuenta registrada $randomword. Que tengas un excelente día.";
    } else {
        echo "No se pudo hacer $randomword: " . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
}
?>
</body>
</html>