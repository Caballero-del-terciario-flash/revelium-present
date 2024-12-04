<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Asistencia</title>
	<link rel="stylesheet" href="styles.css">
    <script src="https://cdn.socket.io/4.5.4/socket.io.min.js"></script>
</head>
<body>
<div class="nav">
	<div class="dropdown">
		<button class="dropbtn">Marcate el presente</button>
		<div class="dropdown-content">
			<a href="index.php">Inicio</a><br>
			<a href="profile.php">Perfil</a><br>
			<a href="buffer.php">Ir a clase</a>
		</div>
	</div>
	</div>

    <h1>Introduce el código de asistencia:</h1>
    <input type="text" id="attendance_code" placeholder="Código de asistencia">
    <button id="submit_code">Enviar Código</button>

    <script>
document.getElementById('submit_code').addEventListener('click', function() {
    const code = document.getElementById('attendance_code').value;
    const student_id = "<?php echo $_SESSION['id']; ?>";

    fetch('http://localhost:3000/submit-code', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            code: code,
            student_id: student_id
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Respuesta del servidor:', data);
        if (data.status === 'success') {
            alert('Asistencia registrada');
        } else {
            alert('Código incorrecto');
        }
    })
    .catch(error => console.error('Error:', error));
});
    </script>
</body>
</html>