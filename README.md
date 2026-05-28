# Sistem Antrian Digital Pintar (Real-Time Smart Queue)

Sistem Antrian Digital adalah aplikasi pengelolaan dan pemanggilan antrian multi-loket berbasis web yang modern. Dilengkapi dengan sinkronisasi waktu nyata (*real-time WebSocket sync*), sistem panggilan suara pintar (*smart voice synthesizer announcer*), cetak tiket kertas thermal virtual, serta antarmuka administrasi bergaya *SaaS premium clean light-mode*.

Aplikasi ini dirancang untuk memberikan kemudahan bagi instansi/kantor layanan publik dalam mengelola antrian secara efisien, transparan, dan profesional.

---

## 🚀 Fitur Utama Aplikasi

1. **Papan Monitor Real-Time Publik (`/monitor`)**:
   - Visualisasi antrian kontras tinggi yang mudah dibaca dari jarak jauh.
   - Pendaran cahaya kartu panggilan dinamis (*glowing ring pulse*) yang berpendar selaras dengan pengucapan audio.
   - Lampu indikator status loket berdenyut (*pulsing status lamp*) hijau untuk aktif dan abu-abu untuk standby.

2. **Layanan Petugas Loket (`/petugas/monitor`)**:
   - Operator meja memiliki kontrol penuh untuk memanggil antrian berikutnya berbasis FIFO (First-In, First-Out) dengan tombol panggil gradasi premium dan efek denyut interaktif.
   - Fitur memanggil ulang antrian (*recall*) dan menyelesaikan layanan (*finish*).
   - Menampilkan sisa antrian menunggu secara dinamis yang terupdate otomatis via WebSocket.

3. **Otorisasi Multi-Peran (RBAC)**:
   - **Admin**: Akses penuh ke panel kontrol admin untuk manajemen pengguna (staf), meja loket, rekapitulasi laporan, dan kustomisasi tiket.
   - **Petugas**: Akses khusus untuk melayani dan memanggil antrian sesuai dengan meja loket yang ditugaskan.
   - **Publik**: Mengambil tiket antrian secara mudah di halaman kios utama.

4. **Kios Tiket Kertas Thermal Virtual (`/`)**:
   - Pengunjung dapat memilih loket tujuan dan mengambil tiket antrian dengan animasi realistis kertas thermal virtual yang meluncur keluar layaknya mesin cetak fisik.

5. **Manajemen Tiket & Pengaturan Kustomisasi (`/settings/ticket`)**:
   - Admin dapat menyesuaikan teks header baris 1 (Nama Instansi), header baris 2 (Alamat / Info), dan footer tiket (Pesan Penutup) secara dinamis dengan visualisasi pratinjau instan (*live-preview*).

6. **Laporan Kinerja Layanan (`/laporan`)**:
   - Pencatatan otomatis waktu mulai dan selesai setiap antrian.
   - Rekapitulasi waktu rata-rata pelayanan loket untuk analisis produktivitas staf.

7. **Desain Premium Clean Light-Mode**:
   - Menggunakan perpaduan tipografi **Outfit** (heading, title & angka antrian besar) dan **Inter** (teks isi).
   - Efek visual modern seperti bayangan berlapis halus (*layered soft shadows*), sudut membulat mewah (*rounded corners*), dan efek sentuhan tombol taktil interaktif.

---

## 💻 Persyaratan Sistem (System Requirements)

Pastikan server Ubuntu Anda memenuhi spesifikasi minimum berikut sebelum memulai instalasi:

*   **Operating System**: Ubuntu 20.04 LTS, 22.04 LTS, atau 24.04 LTS.
*   **PHP**: Versi 8.2 atau lebih baru.
*   **PHP Extensions**: `openssl`, `pdo`, `mbstring`, `xml`, `curl`, `ctype`, `json`, `bcmath`, `sqlite3` atau `mysql`.
*   **Database**: MySQL >= 8.0, MariaDB >= 10.5, atau SQLite 3.
*   **Node.js**: Versi 20.x atau lebih baru (untuk menjalankan Node Socket.io server).
*   **Package Managers**: Composer >= 2.x & NPM >= 10.x.
*   **Web Server**: Nginx (sangat direkomendasikan untuk mendukung reverse-proxy WebSocket).
*   **Process Manager**: PM2 (untuk daemonize server WebSocket Node.js).

---

## 🛠️ Panduan Instalasi Lengkap di Ubuntu Server

Berikut adalah langkah-langkah instalasi lengkap untuk men-deploy aplikasi di Ubuntu.

### Langkah 1: Update Repositori Sistem
Buka terminal server Ubuntu Anda dan jalankan perintah pembaruan sistem:
```bash
sudo apt update && sudo apt upgrade -y
```

### Langkah 2: Instal PHP 8.2 dan Ekstensi Pendukung
Instal PHP 8.2 beserta pustaka ekstensi yang dibutuhkan oleh Laravel:
```bash
sudo apt install software-properties-common -y
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update

sudo apt install php8.2-fpm php8.2-mysql php8.2-curl php8.2-gd php8.2-mbstring php8.2-xml php8.2-zip php8.2-bcmath php8.2-sqlite3 -y
```

### Langkah 3: Instal Nginx, MySQL, dan Node.js
1. **Instal Nginx**:
   ```bash
   sudo apt install nginx -y
   sudo systemctl enable nginx
   sudo systemctl start nginx
   ```
2. **Instal MySQL Server**:
   ```bash
   sudo apt install mysql-server -y
   sudo systemctl enable mysql
   sudo systemctl start mysql
   ```
3. **Instal Node.js (v20.x) & NPM**:
   ```bash
   curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
   sudo apt install nodejs -y
   ```

### Langkah 4: Konfigurasi Database MySQL
1. Masuk ke console MySQL:
   ```bash
   sudo mysql
   ```
2. Jalankan perintah SQL berikut untuk membuat database dan pengguna baru:
   ```sql
   CREATE DATABASE sistem_antrian CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   CREATE USER 'antrian_user'@'localhost' IDENTIFIED BY 'PasswordKuatAnda123!';
   GRANT ALL PRIVILEGES ON sistem_antrian.* TO 'antrian_user'@'localhost';
   FLUSH PRIVILEGES;
   EXIT;
   ```

### Langkah 5: Unduh Proyek dan Instal Dependensi PHP
1. Arahkan direktori aktif ke `/var/www/html/` dan lakukan clone atau pemindahan folder proyek ke direktori tersebut:
   ```bash
   cd /var/www/
   # Pindahkan folder project Anda ke /var/www/sistem-antrian
   sudo mv antrian-online-main sistem-antrian
   cd /var/www/sistem-antrian
   ```
2. Pasang Composer secara global (jika belum ada) dan instal dependensi PHP:
   ```bash
   curl -sS https://getcomposer.org/installer | php
   sudo mv composer.phar /usr/local/bin/composer
   
   composer install --no-dev --optimize-autoloader
   ```

### Langkah 6: Konfigurasi File Lingkungan (`.env`)
1. Salin berkas konfigurasi sampel:
   ```bash
   cp .env.example .env
   ```
2. Buka berkas `.env` menggunakan editor teks (misalnya `nano`):
   ```bash
   nano .env
   ```
3. Sesuaikan konfigurasi utama berikut:
   ```env
   APP_NAME="Sistem Antrian"
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=http://alamat-ip-server-anda

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=sistem_antrian
   DB_USERNAME=antrian_user
   DB_PASSWORD=PasswordKuatAnda123!
   ```
4. Generate *Application Key* Laravel:
   ```bash
   php artisan key:generate
   ```

### Langkah 7: Atur Izin Akses Folder (*Permissions*)
Berikan hak kepemilikan folder proyek ke user `www-data` (Nginx) agar Laravel dapat menulis berkas log, sesi, dan cache:
```bash
sudo chown -R www-data:www-data /var/www/sistem-antrian
sudo find /var/www/sistem-antrian -type f -exec chmod 644 {} \;
sudo find /var/www/sistem-antrian -type d -exec chmod 755 {} \;
sudo chmod -R 775 /var/www/sistem-antrian/storage /var/www/sistem-antrian/bootstrap/cache
```

### Langkah 8: Kompilasi Aset Frontend (Vite)
Instal dependensi JavaScript dan lakukan kompilasi aset statis untuk produksi:
```bash
npm install
npm run build
```

### Langkah 9: Migrasi Database & Seeder Awal
Jalankan perintah berikut untuk membuat seluruh struktur tabel database dan memasukkan data admin/petugas awal:
```bash
php artisan migrate:fresh --seed
```
> [!IMPORTANT]
> Akun default hasil seeder database adalah:
> *   **Username Admin**: `admin` &bull; **Password**: `password`
> *   **Username Petugas**: `petugas` &bull; **Password**: `password`

### Langkah 10: Konfigurasi Server WebSocket (Socket.io) via PM2
Aplikasi menggunakan server WebSocket Node.js mandiri yang berada di folder `socket-server`.
1. Masuk ke direktori `socket-server` dan pasang dependensinya:
   ```bash
   cd /var/www/sistem-antrian/socket-server
   npm install
   ```
2. Instal PM2 secara global untuk menjalankan server WebSocket di latar belakang sebagai service:
   ```bash
   sudo npm install -y -g pm2
   ```
3. Mulai server Node.js dengan PM2:
   ```bash
   pm2 start server.js --name "antrian-websocket-server"
   ```
4. Atur agar PM2 otomatis berjalan kembali apabila server Ubuntu di-reboot:
   ```bash
   pm2 startup systemd
   # Jalankan perintah instruksi yang diberikan oleh keluaran pm2 startup di terminal
   pm2 save
   ```

### Langkah 11: Konfigurasi Virtual Host Nginx & Proxy WebSocket
Buat konfigurasi file virtual host Nginx untuk menyajikan aplikasi Laravel dan melakukan proxy koneksi WebSocket (port 3000) ke Nginx (port 80):
1. Buat berkas konfigurasi baru:
   ```bash
   sudo nano /etc/nginx/sites-available/sistem-antrian
   ```
2. Tempelkan konfigurasi Nginx berikut (sesuaikan nama server/IP):
   ```nginx
   server {
       listen 80;
       server_name alamat-ip-server-anda-atau-domain;
       root /var/www/sistem-antrian/public;

       add_header X-Frame-Options "SAMEORIGIN";
       add_header X-Content-Type-Options "nosniff";

       index index.php;

       charset utf-8;

       # Jalur Utama Laravel
       location / {
           try_files $uri $uri/ /index.php?$query_string;
       }

       location = /favicon.ico { access_log off; log_not_found off; }
       location = /robots.txt  { access_log off; log_not_found off; }

       error_page 404 /index.php;

       # Jalur Pemrosesan PHP-FPM
       location ~ \.php$ {
           fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
           fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
           include fastcgi_params;
       }

       # Proxy koneksi WebSocket Socket.io (Port 3000) ke Nginx
       location /socket.io/ {
           proxy_pass http://127.0.0.1:3000;
           proxy_http_version 1.1;
           proxy_set_header Upgrade $http_upgrade;
           proxy_set_header Connection "upgrade";
           proxy_set_header Host $host;
           proxy_cache_bypass $http_upgrade;
       }

       location ~ /\.(?!well-known).* {
           deny all;
         }
     }
     ```
3. Aktifkan konfigurasi virtual host dan restart Nginx:
   ```bash
   sudo ln -s /etc/nginx/sites-available/sistem-antrian /etc/nginx/sites-enabled/
   sudo nginx -t
   sudo systemctl restart nginx
   ```

Aplikasi **Sistem Antrian Digital Pintar** Anda sekarang telah sepenuhnya aktif dan dapat diakses melalui browser di alamat IP atau domain server Ubuntu Anda!
