📘 Aplikasi Laporan Pelayanan Masyarakat

Sistem web untuk mengelola laporan masyarakat secara cepat, efisien, dan terstruktur. Dibangun menggunakan PHP Native + MySQL, dengan tampilan responsif dan fitur keamanan dasar yang kuat.

📋 Daftar Isi

Fitur Utama

Arsitektur Sistem

Persyaratan Sistem

Instalasi & Setup

Cara Menggunakan

Struktur Project

Keamanan

Development

Troubleshooting

Lisensi

Author & Support

✨ Fitur Utama
Untuk User (Pelapor)

✅ Buat Laporan — Input laporan keluhan/permintaan layanan
✅ Edit Laporan — Update data laporan
✅ Hapus Laporan
✅ Lihat Status Laporan — Diproses / Selesai
✅ Pencarian Laporan

Untuk Admin (Petugas)

✅ Kelola Semua Laporan — Approve, proses, atau tutup laporan
✅ Dashboard Monitoring
✅ Export Data Laporan (CSV)
✅ Manajemen Kategori Laporan (jika diaktifkan)
✓ Activity Log dasar (opsional, jika ada file logger)

⚙️ Fitur Teknis

🔐 Keamanan

SQL Injection Prevention dengan prepared statements

Validasi input dasar

Sanitasi output htmlspecialchars()

📱 Responsive Design

Tampilan mobile & desktop dengan CSS sederhana / Bootstrap (jika digunakan)

🎨 UI Modern

Tabel laporan

Form laporan

Navigasi simpel

🚀 Performa Ringan

PHP Native tanpa framework berat

Query database efisien

🏗️ Arsitektur Sistem

(Disesuaikan dengan struktur project sebelumnya untuk aplikasi laporan pelayanan masyarakat)

project/
│-- config/
│   └── database.php        # Koneksi database
│
│-- public/
│   ├── index.php           # Halaman utama
│   ├── tambah.php          # Form tambah laporan
│   ├── edit.php            # Form edit laporan
│   ├── hapus.php           # Hapus laporan
│   └── assets/
│       ├── css/
│       └── js/
│
│-- includes/
│   ├── header.php          # Header template
│   ├── footer.php          # Footer template
│   └── functions.php       # Fungsi bantuan
│
└── README.md                # Dokumentasi

🗄️ Database Schema
Tabel: laporan
Field	Type	Description
id	INT	Primary key
nama	VARCHAR	Nama pelapor
alamat	TEXT	Alamat pelapor
isi_laporan	TEXT	Isi laporan
kategori	VARCHAR	Kategori laporan
status	ENUM	pending / diproses / selesai
created_at	DATETIME	Timestamp

Jika dalam project kamu schema-nya berbeda, tinggal saya sesuaikan.

🖥️ Persyaratan Sistem

PHP ≥ 7.4 (tested on 8+)

MySQL / MariaDB

Web Server: Apache (XAMPP, Laragon, Nginx)

Browser modern

🚀 Instalasi & Setup
1️⃣ Clone atau Download Project
git clone https://github.com/user/nama-project.git
cd nama-project

2️⃣ Setup Database
Opsi A — phpMyAdmin

Buka http://localhost/phpmyadmin

Buat database baru, misal: pelayanan_masyarakat

Import file database.sql

Opsi B — CLI
mysql -u root -p < database.sql

3️⃣ Konfigurasi Database

Edit file: config/database.php

<?php
$conn = new mysqli("localhost", "root", "", "pelayanan_masyarakat");

4️⃣ Jalankan Web Server

Letakkan folder di:

C:\xampp\htdocs\pelayanan\   (Windows)


Akses melalui:

http://localhost/pelayanan/public

🎯 Cara Menggunakan
1. Tambah Laporan Baru

Buka menu Tambah Laporan

Isi form: nama, alamat, laporan, kategori

Submit → Data tersimpan

2. Lihat Semua Laporan

Pada halaman utama akan muncul tabel laporan

3. Update Laporan

Klik Edit

Ubah field → Simpan

4. Hapus Laporan

Klik Hapus

Konfirmasi → terhapus

5. Admin Mengelola Status

Admin bisa mengubah status laporan:
pending → diproses → selesai

📁 Struktur Project (Lengkap)
pelayanan/
├── config/
│   └── database.php
│
├── public/
│   ├── index.php
│   ├── tambah.php
│   ├── edit.php
│   ├── hapus.php
│   ├── assets/
│   │   ├── css/style.css
│   │   └── js/app.js
│
├── includes/
│   ├── header.php
│   ├── footer.php
│   └── functions.php
│
└── README.md

🔐 Keamanan
Implementasi
Fitur	Implementasi
SQL Injection	Prepared statement (mysqli/pdo)
XSS Prevention	htmlspecialchars()
Session Security	session_start(), cookie flags
Error Handling	Pesan error tidak bocorkan info sensitif
Best Practices

❗ Tidak menyimpan password teks (jika login ada)

Input validation + sanitization

Limit file upload (jika tersedia)

👨‍💻 Development
Jalankan di Local
# Start Apache & MySQL
# Letakkan project di htdocs

http://localhost/pelayanan/

Penambahan Fitur Contoh

Tambahkan kolom lampiran pada laporan:

1. Update database:
ALTER TABLE laporan ADD lampiran VARCHAR(255);

2. Update tambah.php:
<input type="file" name="lampiran">

3. Update save logic:
move_uploaded_file($_FILES['lampiran']['tmp_name'], "uploads/".$filename);

🐛 Troubleshooting
“Database connection failed”

✔ Pastikan MySQL berjalan
✔ Cek config/database.php
✔ Pastikan database sudah ada

“Table doesn’t exist”

✔ Import database.sql

“Data tidak masuk”

✔ Cek query di functions.php
✔ Pastikan form memiliki atribut method="POST"

📄 Lisensi

MIT License — Bebas digunakan untuk pembelajaran & komersial.

👨‍💼 Author

Aatrox
Project demonstrasi aplikasi pelayanan masyarakat berbasis PHP Native + MySQL.

📞 Support

Jika butuh bantuan:

Tanya di ChatGPT

Kirim struktur file untuk revisi

Minta versi README lain (simple, premium, English, dll)
