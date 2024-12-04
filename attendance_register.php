<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "revelium_present";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Error de conexión: " . $conn->connect_error]));
}

$data = json_decode(file_get_contents('php://input'), true);
$student_id = $data['student_id'] ?? null;

$subject_id = $data['subject_id'] ?? null;
if (!$subject_id) {
    die(json_encode(["error" => "Subject ID no proporcionado"]));
}

if ($student_id) {
	$query = "INSERT INTO attendance (student_id, subject_id, state, date) VALUES (?, ?, 'presente', CURDATE())";
	$stmt = $conn->prepare($query);
	$state = "Presente";
	$stmt->bind_param("ii", $student_id, $subject_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => "Presente señor presidente."]);
    } else {
        echo json_encode(["error" => "No se pudo. Jodete: " . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["error" => "Volvé a iniciar sesión o jodete (ID nula)"]);
}

$conn->close();
?>
