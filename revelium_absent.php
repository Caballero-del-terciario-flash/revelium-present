<?php
session_start();

// Verificar que sea un profesor el que ejecuta la acción
if ($_SESSION['type'] != 'teacher') {
    die("No pibe. Esto es para el profe.");
}

// Datos enviados desde el formulario

$subject_id = $_SESSION['subject_id']; // ID de la materia seleccionada
$date = date('Y-m-d'); // Fecha actual

// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'revelium_present');
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
// Obtener todos los estudiantes
$sql_students = "SELECT student_id FROM students";
$result_students = $conn->query($sql_students);

$all_students = [];
while ($row = $result_students->fetch_assoc()) {
    $all_students[] = $row['student_id'];
}

// Obtener estudiantes que ya marcaron presente
$sql_present = "SELECT student_id FROM attendance WHERE subject_id = ? AND date = ? AND state = 'presente'";
$stmt_present = $conn->prepare($sql_present);
$stmt_present->bind_param('is', $subject_id, $date);
$stmt_present->execute();
$result_present = $stmt_present->get_result();

$present_students = [];
while ($row = $result_present->fetch_assoc()) {
    $present_students[] = $row['student_id'];
}

// Calcular ausentes
$absent_students = array_diff($all_students, $present_students);

// Insertar registros de ausentes
if (!empty($absent_students)) {
    $sql_insert_absent = "INSERT INTO attendance (student_id, subject_id, date, state) VALUES (?, ?, ?, 'ausente')";
    $stmt_absent = $conn->prepare($sql_insert_absent);

    foreach ($absent_students as $student_id) {
        $stmt_absent->bind_param('iis', $student_id, $subject_id, $date);
        $stmt_absent->execute();
    }
    echo "El que se durmió ahora está ausente.";
} else {
    echo "Qué piola. Todos están presentes hoy";
}

// Cierre de conexiones
$stmt_present->close();
$stmt_absent->close();
$conn->close();
header('location: index.php');
?>
