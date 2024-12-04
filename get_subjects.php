<?php
session_start();
if ($_SESSION['type'] != "teacher") {
    die("No te hagas el vivo pibe. Esto es para los profes.");
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "revelium_present";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$id= intval($_SESSION['id']);

$query = "SELECT subject_id, subject_name, teacher_id FROM subject WHERE teacher_id = $id";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

$subjects = [];
while ($row = $result->fetch_assoc()) {
    $subjects[] = $row;
}
$_SESSION['subjects'] = $subjects;

$stmt->close();
$conn->close();
header("Location: select_subject.php");
?>