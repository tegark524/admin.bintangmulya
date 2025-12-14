<div align="center">

  <img src="public/logo.png" alt="Logo Bintang Mulya" width="120" height="auto" />
  
  <h1>🚗 Sistem Administrasi Bintang Mulya</h1>
  
  <p>
    <strong>Platform Manajemen Kursus Mengemudi yang Modern dan Efisien</strong>
  </p>

  <p>
    <a href="https://laravel.com">
      <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel" alt="Laravel" />
    </a>
    <a href="https://php.net">
      <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php" alt="PHP" />
    </a>
    <a href="https://tailwindcss.com">
      <img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css" alt="Tailwind CSS" />
    </a>
    <a href="https://adminlte.io">
      <img src="https://img.shields.io/badge/AdminLTE-3.2-343a40?style=for-the-badge&logo=bootstrap" alt="AdminLTE" />
    </a>
  </p>
</div>

<br />

## 📖 Tentang Aplikasi

**Admin Bintang Mulya** adalah sistem informasi manajemen yang dibangun menggunakan framework **Laravel** untuk membantu operasional kursus mengemudi. Aplikasi ini mendigitalkan proses administrasi mulai dari pendaftaran siswa, pengelolaan instruktur, penjadwalan latihan, hingga manajemen paket kursus.

Dibangun dengan antarmuka **AdminLTE** yang responsif dan **Tailwind CSS** untuk komponen modern, sistem ini dirancang untuk kemudahan penggunaan dan kecepatan.

## ✨ Fitur Utama

Berikut adalah fitur-fitur unggulan yang tersedia dalam aplikasi:

| Fitur | Deskripsi |
| :--- | :--- |
| 👥 **Manajemen Siswa** | CRUD data siswa, pendaftaran, dan riwayat latihan. |
| 👨‍🏫 **Manajemen Instruktur** | Pengelolaan data instruktur dan ketersediaan waktu. |
| 📦 **Paket Mengemudi** | Pengaturan jenis paket kursus, harga, dan durasi. |
| 📅 **Penjadwalan (Scheduling)** | Sistem booking jadwal latihan antara siswa dan instruktur. |
| 📝 **Absensi (Attendance)** | Pencatatan kehadiran siswa dan instruktur. |
| 📊 **Dashboard Interaktif** | Ringkasan data penting dan statistik operasional. |
| 🔐 **Otentikasi Aman** | Login, Register, dan Manajemen Password menggunakan Laravel Breeze. |

## 🛠️ Teknologi yang Digunakan

-   **Backend:** Laravel Framework
-   **Frontend:** AdminLTE 3 (Bootstrap 4 based) & Tailwind CSS
-   **Bundler:** Vite
-   **Database:** MySQL / MariaDB
-   **Testing:** Pest PHP
-   **Charts:** Chart.js / Flot (via AdminLTE plugins)

## 📸 Tangkapan Layar

<div align="center">
  <img src="[https://via.placeholder.com/800x400?text=Dashboard+Screenshot](https://drive.google.com/file/d/135wPykxUEIhtD2B4x4Hk0SWcbZO2_6kl/view?usp=drive_link)" alt="Dashboard" />
  <p><i>Tampilan Dashboard Admin</i></p>
</div>

## 🚀 Instalasi & Konfigurasi

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di komputer lokal Anda:

### Prasyarat
Pastikan Anda telah menginstal:
* PHP >= 8.2
* Composer
* Node.js & NPM
* MySQL

### Langkah-langkah

1.  **Clone Repositori**
    ```bash
    git clone [https://github.com/tegark524/admin.bintangmulya.git](https://github.com/tegark524/admin.bintangmulya.git)
    cd admin.bintangmulya
    ```

2.  **Install Dependensi PHP**
    ```bash
    composer install
    ```

3.  **Install Dependensi Frontend**
    ```bash
    npm install
    ```

4.  **Konfigurasi Environment**
    Salin file `.env.example` menjadi `.env`:
    ```bash
    cp .env.example .env
    ```
    Buka file `.env` dan sesuaikan konfigurasi database Anda:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nama_database_kamu
    DB_USERNAME=root
    DB_PASSWORD=
    ```

5.  **Generate Application Key**
    ```bash
    php artisan key:generate
    ```

6.  **Migrasi Database & Seeding**
    ```bash
    php artisan migrate --seed
    ```

7.  **Jalankan Aplikasi**
    Buka dua terminal terpisah.
    
    *Terminal 1 (Vite Development Server):*
    ```bash
    npm run dev
    ```
    
    *Terminal 2 (Laravel Server):*
    ```bash
    php artisan serve
    ```

8.  **Selesai!** 🎉
    Buka browser dan akses `http://localhost:8000`.

## 🧪 Menjalankan Testing

Aplikasi ini menggunakan **Pest** untuk pengujian otomatis. Untuk menjalankan tes:

```bash
php artisan test
