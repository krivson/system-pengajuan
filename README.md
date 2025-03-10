﻿# Sistem Pengajuan

Sistem Pengajuan adalah aplikasi berbasis web untuk mengelola berbagai jenis pengajuan/permohonan dengan fitur notifikasi, pelacakan status, dan manajemen pengguna.

## 📋 Daftar Isi

- [Persyaratan Sistem](#persyaratan-sistem)
- [Instalasi](#instalasi)
- [Struktur Project](#struktur-project)
- [Fitur](#fitur)
- [Teknologi yang Digunakan](#teknologi-yang-digunakan)
- [Penggunaan](#penggunaan)
- [Kontribusi](#kontribusi)

## 💻 Persyaratan Sistem

- PHP >= 7.0
- MySQL/MariaDB
- Apache Web Server
- XAMPP (Direkomendasikan)
- Web Browser Modern (Chrome, Firefox, Safari, Edge)

## 🚀 Instalasi

1. **Persiapan Awal**

   ```bash
   # Hapus folder system-pengajuan jika sudah ada sebelumnya
   rm -rf C:/xampp/htdocs/system-pengajuan

   # Clone atau salin project ke direktori htdocs
   git clone [url-repository] C:/xampp/htdocs/system-pengajuan
   ```

2. **Import Database**

   - Buka phpMyAdmin (http://localhost/phpmyadmin)
   - Buat database baru dengan nama `system_pengajuan`
   - Import file `databases/system_pengajuan.sql`

3. **Konfigurasi**

   - Buka file `system/koneksi.php`
   - Sesuaikan konfigurasi database jika diperlukan

4. **Akses Aplikasi**
   - Buka browser
   - Akses http://localhost/system-pengajuan

## 📁 Struktur Project

```
system-pengajuan/
├── admin/                  # Folder khusus admin
├── assets/                 # Asset statis (CSS, JS, images)
├── databases/              # File database
├── fpdf/                   # Library PDF
├── image/                  # Folder upload gambar
├── system/                 # Core system
└── [File PHP Utama]       # File PHP di root
```

## ✨ Fitur

### Pengguna Umum

- Login dan Registrasi
- Pembuatan Pengajuan
- Pelacakan Status Pengajuan
- Notifikasi Real-time
- Manajemen Profil
- Riwayat Pengajuan

### Administrator

- Dashboard Admin
- Manajemen Pengguna
- Manajemen Jenis Pengajuan
- Persetujuan/Penolakan Pengajuan
- Laporan (PDF)
- Statistik dan Analytics

## 🛠 Teknologi yang Digunakan

- PHP Native
- MySQL
- Bootstrap
- jQuery
- FPDF (PDF Generator)
- SweetAlert
- Light Bootstrap Dashboard

## 📖 Penggunaan

### Login Admin

```
URL: http://localhost/system-pengajuan/admin
Username: admin
Password: [sesuai database]
```

### Login Pengguna

```
URL: http://localhost/system-pengajuan
Username: [email terdaftar]
Password: [password]
```

## 🔄 Pemeliharaan

- Backup database secara berkala
- Periksa log error di folder logs
- Update library dan dependencies secara berkala
- Monitor penggunaan storage untuk uploaded files

## 🤝 Kontribusi

Jika Anda ingin berkontribusi pada project ini:

1. Fork repository
2. Buat branch fitur baru (`git checkout -b fitur-baru`)
3. Commit perubahan (`git commit -m 'Menambah fitur baru'`)
4. Push ke branch (`git push origin fitur-baru`)
5. Buat Pull Request

## 🔑 Catatan Penting

- Backup database sebelum melakukan update sistem
- Periksa compatibility PHP version

## 📞 Kontak

Jika ada pertanyaan atau masalah, silakan membuat issue di repository ini atau hubungi administrator sistem.

## 📝 Lisensi

Project ini dilindungi hak cipta. Penggunaan kode harus sesuai dengan ketentuan yang berlaku.

---

&copy; 2025 Sistem Pengajuan. Hak Cipta Dilindungi.
