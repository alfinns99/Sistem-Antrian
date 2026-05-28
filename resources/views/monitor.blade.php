<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Papan Monitor Antrian - {{ config('app.name', 'Sistem Antrian') }}</title>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { 
            background-color: #f8fafc; 
            color: #0f172a; 
            font-family: 'Inter', sans-serif; 
            height: 100vh; 
            margin: 0; 
            padding: 0; 
            overflow: hidden; 
            display: flex;
            flex-direction: column;
        }
        
        .wrapper { 
            display: flex; 
            flex-direction: column; 
            height: 100vh; 
        }
        
        .navbar-monitor { 
            background: #ffffff; 
            border-bottom: 1px solid #e2e8f0;
            padding: 0.6rem 2rem; 
            box-shadow: 0 4px 20px -5px rgba(15, 23, 42, 0.05); 
            flex-shrink: 0; 
        }
        
        .main-content { 
            flex-grow: 1; 
            display: flex; 
            overflow: hidden; 
            padding: 1rem; 
            gap: 1.5rem; 
        }
        
        .left-panel { 
            flex: 0 0 33%; 
            display: flex; 
            flex-direction: column; 
            gap: 1.5rem; 
            height: 100%; 
        }
        
        .right-panel { 
            flex: 1; 
            display: flex; 
            flex-direction: column; 
            height: 100%; 
        }
        
        .main-call-card { 
            background: white; 
            border-radius: 1.25rem; 
            box-shadow: 0 10px 30px -10px rgba(15, 23, 42, 0.06), 0 1px 3px rgba(15, 23, 42, 0.02);
            overflow: hidden; 
            flex-shrink: 0; 
            border: 1px solid rgba(226, 232, 240, 0.8);
            transition: all 0.3s ease;
        }
        
        .main-call-header { 
            background: #f1f5f9; 
            color: #475569; 
            padding: 12px; 
            font-size: 0.8rem; 
            font-weight: 700; 
            text-align: center; 
            text-transform: uppercase; 
            letter-spacing: 1px;
            border-bottom: 1px solid #e2e8f0;
            font-family: 'Outfit', sans-serif;
        }
        
        .display-nomor { 
            font-size: 6.5rem; 
            font-weight: 800; 
            color: #3d78f7; 
            line-height: 1; 
            margin: 0.5rem 0; 
            font-family: 'Outfit', sans-serif;
            letter-spacing: -2px;
        }
        
        .waiting-list-container { 
            flex-grow: 1; 
            display: flex; 
            flex-direction: column; 
            background: white; 
            border-radius: 1.25rem; 
            padding: 1rem; 
            overflow: hidden; 
            box-shadow: 0 10px 30px -10px rgba(15, 23, 42, 0.06); 
            border: 1px solid rgba(226, 232, 240, 0.8);
        }
        
        .waiting-list-scroll { 
            flex-grow: 1; 
            overflow-y: auto; 
            padding-right: 5px; 
        }
        
        .waiting-list-item { 
            background: #f8fafc; 
            border-radius: 0.75rem; 
            margin-bottom: 8px; 
            padding: 12px 18px; 
            border: 1px solid #f1f5f9; 
            transition: all 0.2s ease;
        }
        
        .grid-container { 
            flex-grow: 1; 
            overflow-y: auto; 
            padding-right: 5px; 
        }
        
        .counter-grid-card { 
            background: white; 
            border-radius: 1.25rem; 
            box-shadow: 0 10px 30px -10px rgba(15, 23, 42, 0.06); 
            height: 100%; 
            border: 1px solid rgba(226, 232, 240, 0.8);
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .counter-name { 
            background: #f1f5f9; 
            color: #475569; 
            padding: 10px; 
            font-size: 0.8rem; 
            font-weight: 700; 
            text-align: center; 
            text-transform: uppercase; 
            letter-spacing: 0.75px;
            font-family: 'Outfit', sans-serif;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .counter-number { 
            font-size: 3rem; 
            font-weight: 800; 
            padding: 1rem 0.5rem; 
            font-family: 'Outfit', sans-serif;
            color: #0f172a;
        }
        
        .footer-monitor { 
            flex-shrink: 0; 
            background: white; 
            padding: 15px; 
            text-align: center; 
            border-top: 1px solid #e2e8f0; 
            font-size: 0.85rem; 
            font-weight: 500;
        }

        /* Glowing Pulse Animation for Active Call */
        .alert-flash { 
            animation: glow-animation 0.8s infinite alternate; 
            border-color: #3d78f7 !important;
        }
        
        @keyframes glow-animation { 
            from { box-shadow: 0 0 10px rgba(61, 120, 247, 0.1); } 
            to { box-shadow: 0 0 30px rgba(61, 120, 247, 0.45); } 
        }
        
        /* Glassmorphic Audio Overlay */
        #audio-unlock-overlay { 
            position: fixed; 
            top: 0; 
            left: 0; 
            width: 100%; 
            height: 100%; 
            background: rgba(15, 23, 42, 0.95); 
            backdrop-filter: blur(15px); 
            z-index: 9999; 
            display: flex; 
            flex-direction: column; 
            justify-content: center; 
            align-items: center; 
            color: white; 
        }
        
        /* Pulse Status Dot */
        .pulse-status {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
            position: relative;
        }
        .pulse-status::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            border-radius: 50%;
            animation: pulse-ring 2s infinite ease-in-out;
        }
        .pulse-success {
            background-color: #10b981;
        }
        .pulse-success::after {
            box-shadow: 0 0 0 6px rgba(16, 185, 129, 0.4);
        }
        .pulse-secondary {
            background-color: #94a3b8;
        }
        .pulse-secondary::after {
            box-shadow: 0 0 0 6px rgba(148, 163, 184, 0.3);
        }
        
        @keyframes pulse-ring {
            0% { transform: scale(0.95); opacity: 0.8; }
            70% { transform: scale(1.8); opacity: 0; }
            100% { transform: scale(0.95); opacity: 0; }
        }

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body>

<div id="audio-unlock-overlay">
    <i class="fas fa-volume-up fa-5x mb-4 text-primary animate-pulse"></i>
    <h2 class="mb-4 fw-bold text-center" style="font-family: 'Outfit', sans-serif;">Klik untuk Mengaktifkan Suara Antrian</h2>
    <p class="text-white-50 mb-4 text-center px-4" style="max-width: 450px;">Aplikasi ini membutuhkan interaksi pertama agar browser mengizinkan pemutaran audio real-time.</p>
    <button id="unlock-btn" class="btn btn-primary btn-lg rounded-pill px-5 py-3 shadow-lg fw-bold scale-hover" style="border: 0; background: linear-gradient(135deg, #3d78f7 0%, #60a5fa 100%);">
        MULAI MONITOR SEKARANG
    </button>
</div>

<div class="wrapper">
    {{-- Header Monitor --}}
    <div class="navbar-monitor d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <i class="fas fa-desktop fa-2x me-3 text-primary"></i>
            <h2 class="mb-0 fw-extrabold" style="font-family: 'Outfit', sans-serif; letter-spacing: -0.5px;">PAPAN MONITOR <span class="text-primary opacity-75">ANTRIAN</span></h2>
        </div>
        <div class="h4 mb-0 fw-bold bg-light text-primary px-4 py-2.5 rounded-pill shadow-sm" style="font-family: 'Outfit', sans-serif;">
            <i class="far fa-clock me-2"></i><span id="live-clock">00:00:00</span>
        </div>
    </div>

    {{-- Main Contents --}}
    <div class="main-content">
        <div class="left-panel">
            {{-- Panggilan Utama --}}
            <div id="main-call-area" class="main-call-card">
                <div class="main-call-header">Panggilan Terbaru</div>
                <div class="p-4 text-center bg-white">
                    <h6 class="text-muted fw-bold mb-1" style="font-size: 0.75rem; letter-spacing: 1px;">NOMOR ANTRIAN</h6>
                    <div id="main-nomor" class="display-nomor">--</div>
                    <div class="h4 fw-bold text-primary bg-primary-subtle py-2 rounded-pill mx-4" id="main-loket" style="font-family: 'Outfit', sans-serif; font-size: 1.15rem;">SILAKAN ANTRI</div>
                </div>
            </div>
            
            {{-- Antrian Menunggu --}}
            <div class="waiting-list-container">
                <h6 class="fw-bold mb-3 text-muted" style="font-family: 'Outfit', sans-serif; font-size: 0.8rem; letter-spacing: 0.5px;"><i class="fas fa-list-ol me-2 text-primary"></i>ANTRIAN MENUNGGU</h6>
                <div id="waiting-list" class="waiting-list-scroll"></div>
            </div>
        </div>
        
        <div class="right-panel">
            <h6 class="fw-bold mb-3 text-muted" style="font-family: 'Outfit', sans-serif; font-size: 0.8rem; letter-spacing: 0.5px;"><i class="fas fa-th-large me-2 text-primary"></i>STATUS MEJA LAYANAN</h6>
            <div class="grid-container">
                <div id="loket-grid" class="row g-3"></div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <footer class="footer-monitor text-muted">
        <strong>SISTEM ANTRIAN</strong> v1.0.0 &bull; Aplikasi dibuat sepenuh ❤️ oleh <strong>AlfinNS</strong>
    </footer>
</div>

<script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    const socket = io("http://localhost:3000");

    $('#unlock-btn').on('click', function() {
        $('#audio-unlock-overlay').fadeOut();
        const startSound = new Audio('/audio/Announcement.wav');
        startSound.volume = 0;
        startSound.play().catch(e => {});
    });

    // Konversi angka ke kata Bahasa Indonesia
    function angkaKeKata(num) {
        if (num === 0) return 'nol';

        const satuan = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan'];

        if (num < 10) return satuan[num];
        if (num === 10) return 'sepuluh';
        if (num === 11) return 'sebelas';
        if (num < 20) return satuan[num - 10] + ' belas';
        if (num < 100) {
            const puluhan = Math.floor(num / 10);
            const sisa = num % 10;
            return satuan[puluhan] + ' puluh' + (sisa > 0 ? ' ' + satuan[sisa] : '');
        }
        // 100 - 999
        const ratusan = Math.floor(num / 100);
        const sisa = num % 100;
        const prefix = ratusan === 1 ? 'seratus' : satuan[ratusan] + ' ratus';
        if (sisa === 0) return prefix;
        return prefix + ' ' + angkaKeKata(sisa);
    }

    // SISTEM ANTRIAN SUARA (Audio Queue)
    let audioQueue = [];
    let isSpeaking = false;

    function processAudioQueue() {
        if (isSpeaking || audioQueue.length === 0) return;

        isSpeaking = true;
        const item = audioQueue.shift();
        const { nomor, loket } = item;

        // LANGKAH 1: Putar Announcement.wav (Pembuka)
        const audioOpening = new Audio('/audio/Announcement.wav');
        
        const speakText = () => {
            const synth = window.speechSynthesis;
            const nomorTerucap = angkaKeKata(parseInt(nomor, 10));
            const text = `Nomor antrian, ${nomorTerucap}. . . Silakan menuju ke, ${loket}.`;
            const utterance = new SpeechSynthesisUtterance(text);
            
            let voices = synth.getVoices();
            let selectedVoice = voices.find(v => v.lang === 'id-ID' && v.name.includes('Google')) || 
                                voices.find(v => v.lang === 'id-ID' && v.name.includes('Female')) ||
                                voices.find(v => v.lang === 'id-ID');
            if (selectedVoice) utterance.voice = selectedVoice;
            
            utterance.lang = 'id-ID';
            utterance.pitch = 1.05; 
            utterance.rate = 0.9;
            
            // LANGKAH 3: Setelah TTS selesai, putar Announcement-end.wav (Penutup)
            utterance.onend = function() {
                const audioClosing = new Audio('/audio/Announcement-end.wav');
                audioClosing.play().then(() => {
                    audioClosing.onended = function() {
                        isSpeaking = false;
                        setTimeout(processAudioQueue, 800);
                    };
                }).catch(e => {
                    isSpeaking = false;
                    setTimeout(processAudioQueue, 800);
                });
            };

            synth.speak(utterance);
        };

        // LANGKAH 2: Setelah Announcement pembuka selesai, mulai TTS
        audioOpening.play().then(() => {
            audioOpening.onended = speakText;
        }).catch(e => {
            console.error("Audio Play Error:", e);
            speakText();
        });
    }

    function panggilSuara(nomor, loket) {
        audioQueue.push({ nomor, loket });
        processAudioQueue();
    }

    socket.on('antrian.dipanggil', (data) => {
        const a = data.antrian;
        $('#main-nomor').text(a.nomor_antrian);
        $('#main-loket').text(a.loket.nama_loket);
        $('#main-call-area').addClass('alert-flash');
        panggilSuara(a.nomor_antrian, a.loket.nama_loket);
        setTimeout(() => { $('#main-call-area').removeClass('alert-flash'); }, 5000);
        fetchData();
    });

    socket.on('antrian.selesai', () => { fetchData(); });
    socket.on('antrian.reset', () => { window.location.reload(); });

    function renderGrid(lokets) {
        const $grid = $('#loket-grid');
        $grid.empty();
        lokets.forEach(l => {
            const hasActive = !!l.antrian_sekarang;
            const activeNum = hasActive ? l.antrian_sekarang.nomor_antrian : '--';
            const statusLabel = hasActive ? 'SEDANG DILAYANI' : 'Standby';
            const lampClass = hasActive ? 'pulse-success' : 'pulse-secondary';
            $grid.append(`
                <div class="col-md-6 col-lg-4">
                    <div class="counter-grid-card text-center">
                        <div class="counter-name text-uppercase small">${l.nama_loket}</div>
                        <div class="counter-number ${hasActive ? 'text-primary fw-extrabold' : 'text-muted fw-bold'}">${activeNum}</div>
                        <div class="pb-3 d-flex align-items-center justify-content-center gap-2">
                            <span class="pulse-status ${lampClass}"></span>
                            <span class="small fw-semibold text-secondary" style="font-size: 0.75rem;">${statusLabel}</span>
                        </div>
                    </div>
                </div>`);
        });
    }

    function renderWaiting(waiting) {
        const $list = $('#waiting-list');
        $list.empty();
        if (waiting.length === 0) { $list.append('<div class="text-muted p-3 text-center small fw-semibold">Tidak ada antrian</div>'); return; }
        waiting.forEach(w => {
            $list.append(`<div class="waiting-list-item d-flex justify-content-between align-items-center">
                <span class="h5 mb-0 fw-extrabold text-primary" style="font-family: 'Outfit', sans-serif;">${w.nomor_antrian}</span>
                <span class="badge bg-warning-subtle text-warning-emphasis px-3 py-1.5 rounded-pill small fw-bold" style="font-size: 0.7rem;">MENUNGGU</span></div>`);
        });
    }

    function fetchData() {
        $.get("{{ route('api.antrian.monitor_data') }}", function(res) {
            renderGrid(res.lokets); renderWaiting(res.antrians_menunggu);
            if (res.antrian_dipanggil && $('#main-nomor').text() === '--') {
                $('#main-nomor').text(res.antrian_dipanggil.nomor_antrian);
                $('#main-loket').text(res.antrian_dipanggil.loket.nama_loket);
            } else if (!res.antrian_dipanggil) {
                $('#main-nomor').text('--');
                $('#main-loket').text('SILAKAN ANTRI');
            }
        });
    }

    function updateClock() {
        const now = new Date();
        $('#live-clock').text(now.toLocaleTimeString('id-ID', { hour12: false }));
    }

    $(document).ready(() => { fetchData(); setInterval(updateClock, 1000); updateClock(); });
</script>
</body>
</html>