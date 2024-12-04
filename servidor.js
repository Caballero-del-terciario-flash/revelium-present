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
        origin: '*',
        methods: ['GET', 'POST']
    }
});

app.use(bodyParser.json());
app.use(cors({
    origin: '*',
    methods: ['GET', 'POST'],
    allowedHeaders: ['Content-Type']
}));

let currentCode = null;

const generateCode = () => {
    return Math.floor(1000 + Math.random() * 9000);
};

setInterval(() => {
    currentCode = generateCode();
    console.log(`Nuevo código generado: ${currentCode}`);
    
    io.emit('codeUpdated', { code: currentCode });
}, 10000);

let subjectIdForClass = null;

app.post('/start-class', (req, res) => {
    const { subject_id } = req.body;
    
    if (subject_id) {
        subjectIdForClass = subject_id;
        res.json({ status: 'success', message: 'Clase iniciada correctamente' });
    } else {
        res.status(400).json({ error: 'No se ha proporcionado subject_id' });
    }
});

app.post('/submit-code', (req, res) => {
    const { code, student_id } = req.body;

    console.log('Código recibido:', code);
    console.log('Código actual:', currentCode);
    
    if (String(code) === String(currentCode)) {
        console.log(`Código correcto recibido de alumno con ID: ${student_id}`);

        axios.post('http://localhost/coding_stravaganza/revelium_present/attendance_register.php', {
            student_id: student_id,
            subject_id: subjectIdForClass,
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

io.on('connection', (socket) => {
    console.log('Cliente conectado');

    if (currentCode) {
        socket.emit('codeUpdated', { code: currentCode });
    }

    socket.on('disconnect', () => {
        console.log('Cliente desconectado');
    });
});

server.listen(3000, '0.0.0.0', () => {
    console.log('Servidor Node.js escuchando en el puerto 3000');
});
