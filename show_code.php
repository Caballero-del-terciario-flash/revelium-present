<?php
session_start();
if (!isset($_POST['subject_id'])) {
    die("Error: No se seleccionó ninguna materia.");
}

$teacher_id = $_SESSION['id'];
$choice = $_POST['subject_id'];
$_SESSION['subject_id'] = $choice;
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presente Señor Presidente</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.socket.io/4.5.4/socket.io.min.js"></script>
</head>
<body>
<div class="nav">
	<div class="dropdown">
		<button class="dropbtn">Hola Alumnosssss</button>
		<div class="dropdown-content">
			<a href="index.php">Inicio</a><br>
			<a href="profile.php">Perfil</a><br>
			<a href="buffer.php">Ir a clase</a>
		</div>
	</div>
	</div>
    <p align="center">
        <span id="big-smoke">Cargando código...</span><br>
        Che pibe pone ese código para la asistencia, no seas peronista.
    </p>
    <p>
        <a href="revelium_absent.php">Terminar Clase</a>
    </p>

    <script>
        const subject_id = "<?php echo $_SESSION['subject_id']; ?>"; 
        const socket = io('http://localhost:3000'); 

        socket.on('codeUpdated', (data) => {
            document.getElementById('big-smoke').textContent = data.code;

            fetch('http://localhost:3000/start-class', { 
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    subject_id: subject_id 
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Respuesta del servidor:', data);
            })
            .catch(error => {
                console.error('Error al enviar subject_id:', error);
            });
        });
    </script>
</body>
</html>
