# 📂 E-DOKUMEN ARSIP BERBASIS WEB

Aplikasi **E-Dokumen Arsip Berbasis Web** adalah sistem pengelolaan arsip digital yang digunakan untuk menyimpan, mengelola, dan mendistribusikan dokumen secara elektronik. Sistem ini dirancang untuk menggantikan pengarsipan manual sehingga proses penyimpanan, pencarian, pengunduhan, dan pengamanan dokumen menjadi lebih **efisien, aman, dan terstruktur**.

Aplikasi dikembangkan menggunakan **PHP Native** dan **MySQL**, dengan struktur sederhana namun rapi, serta mendukung autentikasi pengguna berbasis session.

---

## 🎯 Tujuan Pengembangan

* Menerapkan digitalisasi arsip dokumen
* Mengurangi risiko kehilangan dan kerusakan dokumen fisik
* Mempermudah proses upload, pencarian, dan distribusi dokumen
* Meningkatkan efisiensi kerja administrasi
* Sebagai media pembelajaran pengembangan aplikasi web PHP Native + MySQL

---

## ✨ Fitur Utama

### 👤 Autentikasi Pengguna

* Registrasi pengguna
* Login & Logout
* Manajemen sesi pengguna

### 📁 Manajemen Dokumen

* Upload dokumen (PDF)
* Melihat daftar dokumen
* Melihat detail dokumen
* Download dokumen
* Edit metadata dokumen
* Hapus dokumen arsip

---

## 🔄 Alur Penggunaan Sistem

### 📌 User Flow

1. Pengguna membuka aplikasi
2. Login / Register akun
3. Masuk ke halaman **Daftar Dokumen**
4. Upload dokumen baru
5. Sistem menyimpan file ke server dan metadata ke database
6. Pengguna dapat:

   * Melihat detail dokumen
   * Mengunduh dokumen
   * Mengedit data dokumen
   * Menghapus dokumen
7. Logout dari sistem

---

## 🛠️ Teknologi yang Digunakan

* **Backend** : PHP Native
* **Database** : MySQL / MariaDB
* **Frontend** : HTML5, CSS3
* **Web Server** : Apache (XAMPP / Laragon)

---

## ⚙️ Instalasi & Konfigurasi

```bash
https://github.com/mayfaizhaa/e-dokumen-arsip
```

1. Pindahkan folder project ke `htdocs/`
2. Jalankan Apache & MySQL
3. Buat database dengan nama `e_arsip`
4. Import file `sql/e_arsip.sql`
5. Konfigurasi database pada `config/config.php`

```php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "e_arsip";
```

6. Jalankan aplikasi melalui browser:

```
http://localhost/E-DOKUMEN-ARSIP/
```

---

## 📁 Struktur Project

```
E-DOKUMEN-ARSIP/
├── auth/
│   ├── auth_login.php           # Proses login
│   ├── auth_register.php        # Proses registrasi
│   └── logout.php               # Logout user
│
├── config/
│   ├── config.php               # Konfigurasi database
│   └── init.php                 # Inisialisasi aplikasi
│
├── sql/
│   └── e_arsip.sql              # Struktur database
│
├── uploads/                     # Penyimpanan file dokumen
│   └── *.pdf
│
├── index.php                    # Halaman utama
├── documents.php                # Daftar dokumen
├── upload.php                   # Upload dokumen
├── view_document.php            # Detail dokumen
├── edit_document.php            # Edit dokumen
├── delete_document.php          # Hapus dokumen
├── download.php                 # Download dokumen
├── style.css                    # Styling aplikasi
└── README.md                    # Dokumentasi
```

---

## 🔐 Keamanan Sistem

### Implementasi Keamanan

| Fitur                | Implementasi                     |
| -------------------- | -------------------------------- |
| Password Hashing     | `password_hash()` (bcrypt)       |
| SQL Injection        | Prepared Statements (PDO)        |
| Session Security     | Session-based authentication     |
| File Upload Security | Validasi ekstensi & rename file  |
| XSS Prevention       | `htmlspecialchars()` pada output |

### Best Practices

✅ Tidak menyimpan password plaintext
✅ Validasi & sanitasi input
✅ Pembatasan akses halaman
✅ Penamaan file upload secara acak

---

## 👨‍💻 Development

### Local Development Setup

```bash
# Jalankan Apache & MySQL (XAMPP)
# Akses aplikasi
http://localhost/E-DOKUMEN-ARSIP/
```

### Adding New Features

Contoh: Menambahkan fitur **kategori dokumen**

* Tambahkan field kategori pada tabel database
* Update logic di `upload.php`
* Tampilkan kategori di `documents.php`

---

## 🧪 Testing (Manual)

* Upload dokumen PDF
* Download dokumen
* Edit dan hapus dokumen
* Uji akses tanpa login

---

## 🐛 Troubleshooting

**Database connection failed**

* Pastikan MySQL berjalan
* Periksa konfigurasi di `config/config.php`

**File upload gagal**

* Cek permission folder `uploads/`
* Pastikan file berformat PDF

**Login gagal**

* Pastikan data user tersedia di database
* Cek session PHP aktif

---

## 📝 Catatan & To-Do

### Fitur Selesai ✅

* Autentikasi pengguna
* Upload, download, edit, hapus dokumen
* Manajemen arsip digital

### Pengembangan Lanjutan 🚀

* Pencarian & filter dokumen
* Kategori & tagging dokumen
* Preview dokumen
* Role Admin & User
* Backup arsip otomatis
* Audit log aktivitas

---

## 👨‍💼 Author

**Nama** : *(mayfaizhaa)*
**Institusi** : *(universitas mega buana palopo)*
**Tahun** : 2025

---

📌 *Dokumentasi ini dibuat untuk kebutuhan akademik dan demonstrasi aplikasi web E-Dokumen Arsip berbasis PHP Native & MySQL.*

