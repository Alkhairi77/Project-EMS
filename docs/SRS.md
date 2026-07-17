# **Software Requirements Specification**

**for**

**Event Management System (EMS) MVP Platform**

**Version 1.0 Approved**

**Prepared by**

**AI Product Manager**

**16 Juli 2026**

# **Table of Contents**

* **1. Pendahuluan**  
  * 1.1 Tujuan Penulisan Dokumen  
  * 1.2 Audien yang Dituju  
  * 1.3 Batasan Produk  
  * 1.4 Definisi dan Istilah  
  * 1.5 Referensi  
* **2. Deskripsi Keseluruhan**  
  * 2.1 Deskripsi Produk  
  * 2.2 Fungsi Produk  
  * 2.3 Penggolongan Karakteristik Pengguna  
  * 2.4 Lingkungan Operasi  
  * 2.5 Batasan Desain dan Implementasi  
  * 2.6 Dokumentasi Pengguna  
* **3. Kebutuhan Antarmuka Eksternal**  
  * 3.1 User Interfaces  
  * 3.2 Hardware Interface  
  * 3.3 Software Interface  
  * 3.4 Communication Interface  
* **4. Functional Requirement**  
  * 4.1 Use Case Diagram  
  * 4.2 Skenario Alur Sistem (Use Case & Activity Diagram)  
* **5. Non Functional Requirements**  
* **6. Pemodelan Sistem dan Diagram**  
  * 6.1 Class Diagram  
  * 6.2 Entity-Relationship Diagram (ERD)  
* **7. Spesifikasi Database (MongoDB Collections)**  
* **8. Pengujian & Penerimaan**  
  * 8.1 Strategi Pengujian  
  * 8.2 Kriteria Penerimaan  
* **9. Pengembangan Masa Depan (Phase 2)**

  # **Revision History**

| Name | Date | Reason For Changes | Version |
| :---- | :---- | :---- | :---- |
| Initial Setup | 15/07/2026 | Dokumen dasar untuk MVP (Blade + MongoDB) | 1.0 |

  # **1. Pendahuluan**

  ## **1.1 Tujuan Penulisan Dokumen**

Dokumen Spesifikasi Kebutuhan Perangkat Lunak (SKPL) atau *Software Requirements Specification* (SRS) ini dibuat untuk menjadi acuan dan cetak biru (*blueprint*) dalam pengembangan **Event Management System (EMS) MVP**. Dokumen ini menjadi panduan bagi pengembang (AI Agent/Developer) untuk mengimplementasikan fitur-fitur utama sistem dengan batasan yang disepakati.

## **1.2 Audien yang Dituju dan Pembaca yang Disarankan**

Dokumen ini ditujukan untuk tim pengembang backend/frontend, manajer proyek, serta penjamin mutu (*Quality Assurance*) untuk memastikan sistem yang dibangun sesuai dengan spesifikasi fungsional dan non-fungsional.

## **1.3 Batasan Produk**

Sistem ini dibatasi pada pemenuhan skala **MVP (Minimum Viable Product)**. Aplikasi dijalankan secara monolitik menggunakan **Laravel Blade**, menggunakan autentikasi berbasis sesi (bukan API/JWT), tidak menyertakan modul pembayaran *online* otomatis (*payment gateway*), dan proses *check-in* dilakukan secara manual via tombol klik pada dashboard admin (toko QR scanner kamera ditunda).

## **1.4 Definisi dan Istilah**

* **Organizer**: Pengguna yang memiliki hak akses untuk membuat dan mengelola event mereka sendiri.  
* **Participant**: Pengguna yang mencari event dan mendaftar sebagai peserta.  
* **MVP (Minimum Viable Product)**: Versi produk paling minimal yang memiliki fitur inti fungsional untuk segera diluncurkan.  
* **Check In**: Proses verifikasi kehadiran peserta di lokasi acara secara manual oleh Organizer melalui sistem.

  ## **1.5 Referensi**

* Dokumen *Product Requirements Document (PRD)* EMS MVP v1.1.  
* Dokumen *Software Architecture & Database Design* EMS MVP.

  # **2. Deskripsi Keseluruhan**

  ## **2.1 Deskripsi Produk**

EMS MVP adalah platform website manajemen acara mandiri. Sistem ini memfasilitasi Organizer untuk mengiklankan acara secara digital dan mengumpulkan data pendaftar. Di sisi lain, Participant dapat menjelajahi informasi acara dan mengklaim tiket digital berbasis web secara instan.

## **2.2 Fungsi Produk**

* Autentikasi multi-role (Organizer & Participant) berbasis Laravel Session.  
* Manajemen event penuh (CRUD) khusus untuk Organizer.  
* Pencarian dan penyaringan data event berdasarkan teks judul dan kategori.  
* Sistem pendaftaran instan (*one-click registration*) dengan proteksi *overbooking*.  
* Dashboard metrik dan pelaporan kehadiran manual di sisi panitia.

  ## **2.3 Penggolongan Karakteristik Pengguna**

**Tabel 1 Karakteristik Pengguna**

| Kategori Pengguna | Tugas | Hak Akses ke Aplikasi | Kemampuan Minimum |
| :---- | :---- | :---- | :---- |
| **Organizer** | Mengelola event (CRUD), melihat daftar peserta, memvalidasi status kehadiran. | Akses penuh halaman /organizer/*. | Mengoperasikan browser desktop/mobile & manajemen data web dasar. |
| **Participant** | Mencari event, melihat detail, mendaftar event, melihat tiket digital pribadi. | Akses halaman /events & /dashboard. | Mengoperasikan browser mobile/desktop standar. |

## **2.4 Lingkungan Operasi**

Aplikasi berbasis web monolitik ini dapat dijalankan pada browser modern (Chrome, Firefox, Safari, Edge) baik di perangkat desktop maupun smartphone.

## **2.5 Batasan Desain dan Implementasi**

* **Framework**: Laravel 11.x (Blade Engine & Laravel Breeze).  
* **Database**: MongoDB Community Server melalui package mongodb/laravel-mongodb.  
* **Aesthetic UI**: Mengikuti *Design System* Palet Kombinasi 1 (Indigo & Emerald).

  ## **2.6 Dokumentasi Pengguna**

Disediakan berkas Readme teknis operasional untuk instalasi proyek dan panduan antarmuka visual sederhana pada file design.md.

# **3. Kebutuhan Antarmuka Eksternal**

## **3.1 User Interfaces**

Desain menggunakan utilitas Tailwind CSS bawaan Laravel Breeze dengan dominasi warna Indigo 600 untuk tombol aksi utama, warna Emerald 500 untuk status *success/check-in*, dan komponen kartu berlatar belakang bg-white dengan border halus Slate 200.

## **3.2 Hardware Interface**

* **Server**: Minimal RAM 2GB, CPU 1 Core, Storage SSD bebas.  
* **Client**: Smartphone atau Laptop dengan resolusi layar minimal 360px.

  ## **3.3 Software Interface**

* PHP >= 8.2  
* Composer untuk manajemen dependensi.  
* MongoDB Driver & Ekstensi PHP MongoDB.  
* Node.js & NPM untuk *compiling* asset Vite + Tailwind.

  ## **3.4 Communication Interface**

Komunikasi dilakukan via protokol HTTP/HTTPS standar yang memanfaatkan enkripsi SSL/TLS untuk pengiriman form data diri dan manajemen kuki sesi pengguna (*session cookies*).

# **4. Functional Requirement**

Berikut adalah daftar kebutuhan fungsional sistem yang telah disederhanakan untuk kebutuhan MVP:

| NO | ID | Kebutuhan Fungsional | Keterangan |
| :---- | :---- | :---- | :---- |
| 1 | US1001 | Registrasi Akun Multi-role | Pengguna mendaftar dengan memilih role organizer atau participant. |
| 2 | US1002 | Login Akun | Autentikasi berbasis kuki/sesi web standar (Laravel Breeze). |
| 3 | US1003 | Logout Akun | Menghapus sesi aktif pengguna dari aplikasi. |
| 4 | US2001 | Membuat Event (CRUD) | Organizer membuat event dengan kelengkapan data form terstruktur. |
| 5 | US2002 | Mengelola Status Event | Organizer dapat membatalkan atau mengubah status event. |
| 6 | US2003 | Melihat Dashboard Ringkasan | Organizer memantau total event aktif dan jumlah peserta terdaftar. |
| 7 | US2004 | Check-In Manual Peserta | Organizer menandai kehadiran peserta di pintu masuk via klik tabel. |
| 8 | US3001 | Browse & Search Event | Participant mencari event aktif menggunakan judul teks dan kategori. |
| 9 | US3002 | One-Click Booking | Participant mengklaim tiket dengan validasi sisa kuota atomik. |
| 10 | US3003 | Digital Web Ticket Display | Participant melihat daftar kode unik tiket langsung di web dashboard. |

### **4.1 Use Case Diagram**

flowchart LR

    Participant((Participant))

    Organizer((Organizer))

    subgraph Event Management System MVP

        UC1(Registrasi & Login Akun)

        UC2(Menelusuri & Cari Event)

        UC3(Mendaftar Event/Klaim Tiket)

        UC4(Melihat Tiket Web Digital)

        UC5(Kelola Event CRUD)

        UC6(Check-In Manual Peserta)

        UC7(Melihat Dashboard Ringkasan)

    end

    Participant --> UC1

    Participant --> UC2

    Participant --> UC3

    Participant --> UC4

    Organizer --> UC1

    Organizer --> UC2

    Organizer --> UC5

    Organizer --> UC6

    Organizer --> UC7

## **4.2 Skenario Alur Sistem (Use Case & Activity Diagram)**

### **4.2.1 Kasus 1: Registrasi Akun Multi-role**

* **Deskripsi**: Calon pengguna mendaftarkan akun baru ke dalam database dan memilih peran sebagai *Organizer* atau *Participant*.  
* **Stimulus & Response**:

| Action by User | Response from System |
| :---- | :---- |
| 1. Membuka halaman registrasi website. | Menampilkan form registrasi Breeze lengkap dengan pilihan dropdown Role. |
| 2. Mengisi Nama, Email, Sandi, dan memilih Role. | Melakukan validasi format data input server-side. |
| 3. Mengeklik tombol "Register". | Membuat dokumen baru di koleksi users, mengaktifkan sesi login, dan mengarahkan pengguna ke dashboard sesuai role pilihan. |

*   
  **Activity Diagram**:  
  Cuplikan kode  
  stateDiagram-v2  
      [*] --> BukaHalamanDaftar  
      BukaHalamanDaftar --> IsiFormDataDiri  
      IsiFormDataDiri --> PilihRoleUser  
      PilihRoleUser --> KlikSubmitDaftar  
      KlikSubmitDaftar --> ValidasiSistem  
      ValidasiSistem --> SimpanMongoDB: Data Valid  
      ValidasiSistem --> IsiFormDataDiri: Data Tidak Valid  
      SimpanMongoDB --> RedirectDashboardRole  
      RedirectDashboardRole --> [*]


  ### **4.2.2 Kasus 2: Organizer Membuat Event**

* **Deskripsi**: Penyelenggara membuat postingan acara baru agar dapat diakses oleh publik.  
* **Stimulus & Response**:

| Action by User | Response from System |
| :---- | :---- |
| 1. Mengeklik tombol "Create Event" di Dashboard Organizer. | Menyajikan halaman formulir input data event lengkap sesuai spesifikasi PRD. |
| 2. Mengisi judul, deskripsi, lokasi, kuota, tanggal, kategori, dan mengunggah gambar banner. | Menangkap request form data. |
| 3. Mengeklik tombol "Save Event". | Menyimpan berkas banner ke *local storage*, membuat dokumen baru di koleksi events, dan menampilkan pesan sukses di halaman manajemen utama. |

*   
  **Activity Diagram**:  
  Cuplikan kode  
  stateDiagram-v2  
      [*] --> MasukMenuEvent  
      MasukMenuEvent --> IsiFormDetailAcara  
      IsiFormDetailAcara --> UnggahGambarBanner  
      UnggahGambarBanner --> KlikSimpan  
      KlikSimpan --> SimpanKeStorageDanDB  
      SimpanKeStorageDanDB --> TampilkanTabelEventOrganizer  
      TampilkanTabelEventOrganizer --> [*]


  ### **4.2.3 Kasus 3: Participant Memesan Tiket (One-Click Booking)**

* **Deskripsi**: Proses pendaftaran acara oleh peserta secara instan yang dikawal proteksi batas kuota aman database.  
* **Stimulus & Response**:

| Action by User | Response from System |
| :---- | :---- |
| 1. Membuka detail halaman event yang diinginkan. | Menampilkan rincian event dan status sisa kuota terkini. |
| 2. Mengeklik tombol "Daftar Sekarang". | Memulai pengecekan ketersediaan alokasi kuota secara atomik di server. |
|  | **Sistem (Kondisi A - Cukup)**: Mengurangi kapasitas event, melahirkan dokumen baru di koleksi registrations dengan registration_code unik, lalu mengalihkan ke dashboard tiket. |
|  | **Sistem (Kondisi B - Penuh)**: Membatalkan proses dan memicu pesan error: *"Kuota Sudah Penuh!"*. |

*   
  **Activity Diagram**:  
  Cuplikan kode  
  stateDiagram-v2  
      [*] --> BukaDetailAcara  
      BukaDetailAcara --> KlikDaftarSekarang  
      KlikDaftarSekarang --> HitungSisaKuotaDB  
      HitungSisaKuotaDB --> GenerateTiketSukses: Kuota Tersedia  
      HitungSisaKuotaDB --> TampilkanPesanGagal: Kuota Habis  
      GenerateTiketSukses --> RedirectDashboardTiket  
      TampilkanPesanGagal --> BukaDetailAcara  
      RedirectDashboardTiket --> [*]


  ### **4.2.4 Kasus 4: Peserta Check-In Manual**

* **Deskripsi**: Validasi kehadiran peserta di meja registrasi fisik dengan merubah status pendaftaran secara manual di dashboard panitia.  
* **Stimulus & Response**:

| Action by User | Response from System |
| :---- | :---- |
| 1. Organizer membuka sub-menu "Lihat Peserta" pada baris event tertentu. | Memuat tabel nama-nama peserta terdaftar beserta status kehadiran saat ini. |
| 2. Organizer mencari nama/kode peserta yang datang lalu klik tombol "Set Hadir (Check In)". | Menerima request ID registrasi target. |
| 3. Sistem merubah status database. | Memperbarui kolom status dari Registered menjadi Checked In di MongoDB secara instan dan memuat ulang tabel halaman dengan indikator sukses hijau. |

*   
  **Activity Diagram**:  
  Cuplikan kode  
  stateDiagram-v2  
      [*] --> BukaDaftarPesertaEvent  
      BukaDaftarPesertaEvent --> CariNamaAtauKodeTiket  
      CariNamaAtauKodeTiket --> KlikTombolSetHadir  
      KlikTombolSetHadir --> UpdateStatusMongoDB  
      UpdateStatusMongoDB --> RefreshTampilanBadgeHijau  
      RefreshTampilanBadgeHijau --> [*]


  # **5. Non Functional Requirements**

| ID | Parameter | Kebutuhan Eksklusif MVP |
| :---- | :---- | :---- |
| SU-1 | **Availability** | Sistem beroperasi penuh 24/7 di server cloud lokal. |
| SU-2 | **Usability (Ergonomy)** | Antarmuka bersih, responsif, dan ramah tampilan mobile menggunakan standar CSS Tailwind. |
| SU-3 | **Performance (Response Time)** | Operasi penayangan feed event dan proses pembukuan reservasi data harus selesai dalam waktu kurang dari 2 detik. |
| SU-4 | **Security** | Seluruh celah form diproteksi dari serangan CSRF secara bawaan oleh *Web Guard Middleware* Laravel, serta enkripsi password akun memakai algoritma Bcrypt kuat. |
| SU-5 | **Concurrency Safe** | Sistem wajib mencegah *overbooking* kuota tiket memakai perhitungan kalkulasi terisolasi pada aras kontrol database. |

  # **6. Pemodelan Sistem dan Diagram**

  ## **6.1 Class Diagram**

  Cuplikan kode

  classDiagram

      class User {

          +ObjectId id

          +String name

          +String email

          +String password

          +String role

      }

      class Event {

          +ObjectId id

          +ObjectId user_id

          +String judul

          +String deskripsi

          +String banner

          +String lokasi

          +Integer kapasitas

          +Integer harga

          +String tanggal

          +String jam

          +String kategori

          +String status

      }

      class Registration {

          +ObjectId id

          +ObjectId event_id

          +ObjectId user_id

          +String registration_code

          +String status

      }


      User "1" -- "*" Event : "Membuat (Organizer)"

      Event "1" -- "*" Registration : "Memiliki Pendaftar"

      User "1" -- "*" Registration : "Mengklaim Tiket (Participant)"


  ## **6.2 Entity-Relationship Diagram (ERD)**

  Cuplikan kode

  erDiagram

      USERS ||--o{ EVENTS : "mengorganisir"

      EVENTS ||--o{ REGISTRATIONS : "memiliki pendaftaran"

      USERS ||--o{ REGISTRATIONS : "membeli tiket"


      USERS {

          object_id id PK

          string name

          string email

          string password

          string role

      }

      EVENTS {

          object_id id PK

          object_id user_id FK

          string judul

          string deskripsi

          string banner

          string lokasi

          int kapasitas

          int harga

          string tanggal

          string jam

          string kategori

          string status

      }

      REGISTRATIONS {

          object_id id PK

          object_id event_id FK

          object_id user_id FK

          string registration_code

          string status

      }


  # **7. Spesifikasi Database (MongoDB Collections)**

Sistem NoSQL diimplementasikan ke dalam 3 koleksi terstruktur dengan penempatan indeks pencarian cepat:

### **1. Koleksi: users**

* **Indeks**: email (Unique Hash Index).  
* **Tipe Data**: _id (ObjectId), name (String), email (String), password (String Hashed), role (String: organizer/participant).

  ### **2. Koleksi: events**

* **Indeks**: user_id (Foreign Key index), kategori (Search filter index).  
* **Tipe Data**: _id (ObjectId), user_id (ObjectId), judul (String), deskripsi (String), banner (String Path), lokasi (String), kapasitas (Int), harga (Int), tanggal (String), jam (String), kategori (String), status (String).

  ### **3. Koleksi: registrations**

* **Indeks**: event_id (Index), registration_code (Unique Index).  
* **Tipe Data**: _id (ObjectId), event_id (ObjectId), user_id (ObjectId), registration_code (String Unique), status (String: Registered/Checked In).

  # **8. Pengujian & Penerimaan**

  ## **8.1 Strategi Pengujian (Testing Strategy)**

* **Feature Validation**: Memastikan form validasi bawaan Laravel bekerja menolak tanggal pendaftaran masa lalu dan membatasi ukuran unggahan file banner gambar agar tidak membebani penyimpanan lokal.  
* **Concurrency Stress Test**: Menjalankan skrip simulasi hit ganda serentak untuk membuktikan modul pengecekan kuota aman dan tidak menghasilkan nilai kuota minus.

  ## **8.2 Kriteria Penerimaan (Acceptance Criteria)**

1. **Akses Role Terisolasi**: Akun bertipe *Participant* mutlak diblokir dan tidak bisa membuka rute url administrasi /organizer/* (dialihkan otomatis lewat Laravel Middleware).  
2. **Siklus Check-In Akurat**: Ketika tombol klik "Set Hadir" ditekan oleh panitia, label status berubah menjadi hijau (Checked In) secara instan dan data tersimpan permanen di database.

   # **9. Pengembangan Masa Depan (Phase 2)**

Setelah fondasi MVP ini selesai dan stabil, ruang ekspansi berikutnya mencakup:

* **Integrasi Kamera Web**: Mengaktifkan modul QR Code Generator pada tiket digital peserta dan QR Code Scanner otomatis berbasis javascript pada browser panitia.  
* **Asynchronous Job Email**: Mengintegrasikan Laravel Queue untuk memproses pembuatan tiket PDF dan pengirimannya ke kotak masuk surel peserta tanpa mengganggu kecepatan interaksi antarmuka web.


