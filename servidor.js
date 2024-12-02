const express = require('express');
const http = require('http');
const socketIo = require('socket.io');
const axios = require('axios');
const bodyParser = require('body-parser');
const cors = require('cors');

const app = express();
const server = http.createServer(app);
const io = socketIo(server, {
    cors: {
        origin: '*', // Permitir todas las conexiones (modificar según necesidades)
        methods: ['GET', 'POST']
    }
});

// Middleware para manejar JSON
app.use(bodyParser.json());
app.use(cors({
    origin: '*', // Permitir todas las solicitudes
    methods: ['GET', 'POST'],
    allowedHeaders: ['Content-Type']
}));

// Variable para almacenar el código actual
let currentCode = null;

// Función para generar un código aleatorio de 4 dígitos
const generateCode = () => {
    return Math.floor(1000 + Math.random() * 9000);
};

// Actualizar el código cada 10 segundos
setInterval(() => {
    currentCode = generateCode();
    console.log(`Nuevo código generado: ${currentCode}`);
    
    // Emitir el nuevo código a todos los clientes conectados
    io.emit('codeUpdated', { code: currentCode });
}, 10000); // Cambia el intervalo si es necesario

let subjectIdForClass = null; // Asegúrate de que esta variable esté definida antes de ser utilizada

// Endpoint para iniciar la clase y almacenar el subject_id
app.post('/start-class', (req, res) => {
    const { subject_id } = req.body;
    
    if (subject_id) {
        subjectIdForClass = subject_id; // Asignamos el subject_id a la clase en curso
        res.json({ status: 'success', message: 'Clase iniciada correctamente' });
    } else {
        res.status(400).json({ error: 'No se ha proporcionado subject_id' });
    }
});

// Endpoint para recibir el código desde un cliente (alumno)
app.post('/submit-code', (req, res) => {
    const { code, student_id } = req.body;

    console.log('Código recibido:', code);
    console.log('Código actual:', currentCode);
    
    // Verificar si el código recibido coincide con el generado
    if (String(code) === String(currentCode)) {
        console.log(`Código correcto recibido de alumno con ID: ${student_id}`);

        // Aquí puedes registrar la asistencia en función del subjectIdForClass
        axios.post('http://localhost/coding_stravaganza/revelium_present/attendance_register.php', {
            student_id: student_id,
            subject_id: subjectIdForClass, // Usar el subject_id de la clase
            code: code
        })
        .then(response => {
            console.log('Respuesta de PHP:', response.data);
            res.json({ status: 'success', message: 'Asistencia registrada correctamente' });
        })
        .catch(error => {
            console.error('Error al registrar asistencia:', error.response ? error.response.data : error.message);
            res.status(500).json({ status: 'error', message: 'Error al registrar asistencia' });
        });
    } else {
        res.status(400).json({ status: 'error', message: 'Código incorrecto' });
    }
});

// WebSockets para manejar conexiones y emitir el código a los clientes
io.on('connection', (socket) => {
    console.log('Cliente conectado');

    // Enviar el código actual al cliente que se conecta
    if (currentCode) {
        socket.emit('codeUpdated', { code: currentCode });
    }

    // Manejar desconexión del cliente
    socket.on('disconnect', () => {
        console.log('Cliente desconectado');
    });
});

// Iniciar el servidor
server.listen(3000, '0.0.0.0', () => {
    console.log('Servidor Node.js escuchando en el puerto 3000');
});
