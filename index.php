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
</html>
<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "revelium_present";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if (!isset ($_SESSION['id'])){
	die("Me parece que no iniciaste sesión. Andate al perfil a ver qué onda.");
}
$user_type = $_SESSION['type'];
$user_id = $_SESSION['id'];
$name = $_SESSION['name'];
$surname = $_SESSION['surname'];
echo "$name $surname<br>";

if ($user_type == 'student') {
    $query = "
        SELECT 
            s.subject_name, 
            COUNT(CASE WHEN a.state = 'presente' THEN 1 END) AS presente_count,
            COUNT(*) AS total_classes,
            ROUND(100 * COUNT(CASE WHEN a.state = 'presente' THEN 1 END) / COUNT(*)) AS attendance_percentage,
            GROUP_CONCAT(CONCAT(DATE_FORMAT(a.date, '%d/%m'), ': ', a.state) ORDER BY a.date ASC SEPARATOR '<br>') AS attendance_details
        FROM 
            attendance a
        JOIN 
            subject s ON a.subject_id = s.subject_id
        WHERE 
            a.student_id = ?
        GROUP BY 
            s.subject_id
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<br>Tus asistencias:<br>";
    while ($row = $result->fetch_assoc()) {
        echo "<br>{$row['subject_name']} ({$row['presente_count']}/{$row['total_classes']}) ({$row['attendance_percentage']}%)<br>";
        echo $row['attendance_details'] . "<br>";
    }
} elseif ($user_type == 'teacher') {
$teacher_id = $_SESSION['id'];
$query = "
    SELECT 
        s.subject_name AS subject_name,   -- Nombre de la materia
        a.date AS attendance_date,        -- Fecha de la asistencia
        st.name AS student_name,          -- Nombre del estudiante
        st.surname AS student_surname,    -- Apellido del estudiante
        a.state AS attendance_state       -- Estado de la asistencia (presente/ausente)
    FROM attendance a
    JOIN students st ON a.student_id = st.student_id
    JOIN subject s ON a.subject_id = s.subject_id
    JOIN teachers t ON s.teacher_id = t.teacher_id
    WHERE t.teacher_id = ?  -- Filtra por el ID del profesor
    ORDER BY s.subject_name, a.date, st.name, st.surname;
";
$stmt = $conn->prepare($query);
if ($stmt === false) {
    die("Error al preparar la consulta: " . $conn->error);
}
$stmt->bind_param("i", $teacher_id);  
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $current_subject = null;
    $attendance_by_subject = [];

    while ($row = $result->fetch_assoc()) {
        $subject_name = $row['subject_name'];
        $attendance_date = $row['attendance_date'];
        $student_name = $row['student_name'];
        $student_surname = $row['student_surname'];
        $attendance_state = ($row['attendance_state'] === 'presente') ? 'Presente' : 'Ausente';

        if (!isset($attendance_by_subject[$subject_name])) {
            $attendance_by_subject[$subject_name] = [];
        }

        $attendance_by_subject[$subject_name][] = [
            'date' => $attendance_date,
            'student_name' => $student_name,
            'student_surname' => $student_surname,
            'attendance_state' => $attendance_state
        ];
    }

    foreach ($attendance_by_subject as $subject => $attendances) {
        echo "<br>Materia: $subject<br>";

        $current_date = null;
        foreach ($attendances as $attendance) {
            if ($current_date !== $attendance['date']) {
                if ($current_date !== null) {
                }

                $current_date = $attendance['date'];

                echo "<br>Fecha: " . $attendance['date'] . "<br><br>";
            }

            echo $attendance['student_name'] . " " . $attendance['student_surname'] . " - " . $attendance['attendance_state'] . "<br>";
        }

    }
} else {
    echo "No se encontraron registros.";
}
}
$stmt->close();
$conn->close();
?>
