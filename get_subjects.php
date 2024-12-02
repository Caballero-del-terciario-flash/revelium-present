<?php
// select subject_name from subject where teacher_id = $_SESSION['type'].'_'.$_SESSION['id'];
// Conexión a la base de datos
session_start();
if ($_SESSION['type'] != "teacher") {
    die("No te hagas el vivo pibe. Esto es para los profes.");
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "revelium_present";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$id= intval($_SESSION['id']);

// Obtener las materias del profesor
$query = "SELECT subject_id, subject_name, teacher_id FROM subject WHERE teacher_id = $id";
$stmt = $conn->prepare($query);
//$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();

// Guardar las materias en un array
$subjects = [];
while ($row = $result->fetch_assoc()) {
    $subjects[] = $row;
}
$_SESSION['subjects'] = $subjects;

$stmt->close();
$conn->close();
header("Location: select_subject.php");
?>