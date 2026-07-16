# Product Requirements Document (PRD) - MVP Edition
## Event Management System (EMS) Platform

**Version:** 1.1 (Sederhana - MVP)  
**Date:** July 15, 2026  
**Status:** Approved for Development  
**Author:** AI Product Manager  

---

## 1. Executive Summary & Product Vision

### 1.1 Executive Summary
Event Management System (EMS) MVP adalah platform berbasis website yang disederhanakan untuk mempertemukan Penyelenggara Acara (Organizer) dan Peserta (Participant). Fokus utama MVP ini adalah menyediakan fungsi inti CRUD acara, pendaftaran mandiri yang cepat, dan validasi kehadiran manual yang efisien tanpa komponen perangkat keras/kamera tambahan. Sistem ini dibangun menggunakan **Laravel 11 (Blade Engine)** dan **MongoDB**.

### 1.2 Product Vision
Menyediakan sistem manajemen acara yang andal dan selesai tepat waktu dengan berfokus pada kemudahan penggunaan, performa yang stabil, serta alur kerja data yang efisien.

---

## 2. User Roles & Personas

Sistem ini membagi akses pengguna menggunakan Session Auth & Middleware bawaan Laravel:

### 2.1 Organizer (Penyelenggara)
*   **Tujuan Utama:** Membuat event, melihat siapa saja yang mendaftar, dan menandai kehadiran peserta di lokasi secara manual lewat sistem.

### 2.2 Participant (Peserta)
*   **Tujuan Utama:** Mencari event secara instan, melakukan pendaftaran satu kali klik, dan melihat tiket digital mereka di halaman web.

---

## 3. Epics & User Stories (MVP Scope)

### 3.1 Authentication Epic
*   **User Story 1:** Sebagai Pengguna, saya ingin mendaftar akun baru (Nama, Email, Password, Pilih Role) agar bisa masuk ke sistem.
*   **User Story 2:** Sebagai Pengguna terdaftar, saya ingin login menggunakan sesi web konvensional yang aman (Laravel Session) agar tidak perlu sering login kembali.

### 3.2 Core Event Epic
*   **User Story 3:** Sebagai Organizer, saya ingin membuat, membaca, mengubah, dan menghapus (CRUD) data event milik saya sendiri.
*   **User Story 4:** Sebagai Participant, saya ingin melihat daftar semua event yang aktif dan mencari event berdasarkan judul atau kategori.
*   **User Story 5:** Sebagai Participant, saya ingin melihat detail event lengkap dengan sisa kuota sebelum memutuskan untuk mendaftar.

### 3.3 Registration & Attendance Epic
*   **User Story 6:** Sebagai Participant, saya ingin mendaftar ke suatu event dengan satu klik, yang akan mengurangi kuota event dan menerbitkan kode tiket digital di dashboard saya.
*   **User Story 7:** Sebagai Organizer, saya ingin melihat daftar nama peserta yang terdaftar pada event saya dan mengeklik tombol "Check In" untuk mengonfirmasi kehadiran mereka secara manual di lokasi.

---

## 4. Detailed Functional Requirements

### 4.1 Authentication Module (Standard Web Session)
*   **Teknologi:** Menggunakan **Laravel Breeze** (Cookie/Session based).
*   **Alur:** Pengguna memilih Role (`organizer` atau `participant`) saat registrasi. Pilihan role ini menentukan arah redirect halaman setelah login.

### 4.2 Event Management Module (Organizer)
Setiap data event disimpan ke dalam koleksi `events` di MongoDB.
*   **Spesifikasi Kolom Data (Fields):**

| Nama Kolom | Tipe Data | Keterangan / Validasi |
| :--- | :--- | :--- |
| `judul` | String | Wajib isi, maks 150 karakter. |
| `deskripsi` | Text | Penjelasan detail acara. |
| `banner` | String (URL) | Path file gambar yang diunggah ke *local storage*. |
| `lokasi` | String | Alamat fisik tempat acara atau link online. |
| `kapasitas` | Integer | Jumlah total kuota tersedia (Min: 1). |
| `harga` | Integer | Harga tiket (Angka `0` untuk event gratis). |
| `tanggal` | Date | YYYY-MM-DD (Harus tanggal yang akan datang). |
| `jam` | Time | HH:MM (Waktu mulai acara). |
| `kategori` | String | Pilihan terbatas: `Workshop`, `Seminar`, `Competition`, `Bootcamp`, `Webinar`, `Festival`. |
| `status` | String | Status acara: `Draft`, `Published`, `Cancelled`. |

### 4.3 Search & Detail Module (Participant)
*   **Pencarian Sederhana:** Filter pencarian berbasis teks pada kolom `judul` dan dropdown filter berdasarkan `kategori`.
*   **Detail Halaman:** Menampilkan seluruh informasi event, sisa kuota terhitung, dan tombol **"Daftar Sekarang"**.
*   **Pencegahan Overbooking:** Menggunakan operasi atomik `$inc` MongoDB untuk mengurangi kuota saat tombol daftar ditekan, mencegah kuota menjadi minus jika diakses bersamaan.

### 4.4 Sistem Tiket & Check-In Manual
*   **Pembuatan Tiket:** Jika pendaftaran sukses, sistem membuat dokumen baru di koleksi `registrations` yang berisi `registration_code` unik berbasis teks (contoh: `EVT-2026-XXXX`).
*   **Tampilan Tiket:** Tiket ditampilkan langsung di halaman web Dashboard Participant (berupa kartu digital bersih, tanpa fitur unduh PDF).
*   **Check-In Pintu Masuk:** Organizer membuka daftar peserta event di laptop/HP, mencari nama atau kode tiket peserta yang datang, lalu menekan tombol **"Check In"** di baris tabel. Status dokumen di database berubah menjadi `Checked In`.

---

## 5. Dashboard & Interface Requirements (Laravel Blade)

### 5.1 Organizer Dashboard
*   **Ringkasan Metrik (Informasi Angka):**
    *   Total Event yang Pernah Dibuat
    *   Total Seluruh Peserta Terdaftar
    *   Total Event yang Berstatus Aktif (`Published`)
*   **Tabel Manajemen Utama:**
    *   Kolom: Nama Event | Tanggal | Kuota Terisi (Contoh: `15/50`) | Status | Aksi (`Edit`, `Lihat Peserta`).
*   **Halaman Daftar Peserta (Sub-Menu):**
    *   Menampilkan tabel nama peserta dan status kehadiran mereka (`Registered` / `Checked In`), serta tombol aksi **"Set Hadir (Check In)"**.

### 5.2 Participant Dashboard
*   **Tampilan Tab Acara:**
    *   *Upcoming Event:* Daftar event yang akan diikuti di masa depan beserta kode tiket digitalnya.
    *   *Past Event:* Riwayat event yang sudah selesai dihadiri sebelumnya.

---

## 6. Technical Stack

*   **Framework:** Laravel 11.x
*   **Template Engine:** Laravel Blade + TailwindCSS (Via Laravel Breeze)
*   **Database:** MongoDB via package `mongodb/laravel-mongodb`
*   **Metode Autentikasi:** Session & Cookie bawaan (Web Guard)