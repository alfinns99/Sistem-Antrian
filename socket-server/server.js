const express = require('express');
const app = express();
const http = require('http').createServer(app);
const io = require('socket.io')(http, {
    cors: { origin: "*" }
});
const bodyParser = require('body-parser');

app.use(bodyParser.json());

// Endpoint untuk menerima data dari Laravel
app.post('/broadcast', (req, res) => {
    const { event, data } = req.body;
    console.log(`Menyiarkan event: ${event}`, data);
    
    // Broadcast ke semua client Socket.io
    io.emit(event, data);
    
    res.json({ success: true });
});

io.on('connection', (socket) => {
    console.log('Client monitor terkoneksi:', socket.id);
});

const PORT = 3000;
http.listen(PORT, () => {
    console.log(`Socket.io Bridge berjalan di port ${PORT}`);
    console.log(`Menunggu data dari Laravel di http://localhost:${PORT}/broadcast`);
});
