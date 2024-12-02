<html lang="en">
<head>
    <title>Mortadeleado</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="nav">
	<div class="dropdown">
		<button class="dropbtn">Mortadela</button>
		<div class="dropdown-content">
			<a href="index.php">Inicio</a><br>
			<a href="profile.php">Perfil</a><br>
			<a href="buffer.php">Ir a clase</a>
		</div>
	</div>
	</div>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "revelium_present";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$mail = $_POST['mail'];
$target = $_POST['type'];

$sql = "DELETE FROM $target WHERE mail = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $mail);
if ($stmt->execute()) {
    echo "Hicimos mortadela la cuenta. Suerte en el más allá.";
} else {
    echo "No se pudo. Jodete: " . $stmt->error;
}


$stmt->close();
$conn->close();
?>
</body>
</html>