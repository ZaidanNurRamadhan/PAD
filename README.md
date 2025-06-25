# Aplikasi Manajemen Stok KONEK (PAD-fe)

Aplikasi Manajemen Stok KONEK adalah sebuah sistem berbasis web yang dirancang untuk membantu pengelolaan inventaris, transaksi penjualan, informasi pemasok, data toko, dan manajemen karyawan. Aplikasi ini mendukung dua peran pengguna utama: Pemilik (Owner) dan Karyawan, dengan fungsionalitas yang disesuaikan untuk setiap peran.

## Fitur Utama

  * **Manajemen Otentikasi Pengguna**:
      * Login dan Logout.
      * Fitur Lupa Kata Sandi dan Reset Kata Sandi melalui email.
  * **Sistem Peran Pengguna**:
      * **Owner**: Akses penuh ke semua fitur, termasuk *dashboard* lengkap, manajemen gudang, transaksi, laporan, pemasok, toko, dan karyawan.
      * **Karyawan**: Akses terbatas hanya pada manajemen gudang dan transaksi.
  * **Dashboard Interaktif**:
      * Melihat monitoring penyebaran produk.
      * Grafik penjualan dan retur (harian/bulanan).
      * Daftar produk terlaris.
      * Notifikasi produk dengan stok menipis.
  * **Manajemen Gudang**:
      * Menambah, mengedit, dan menghapus data produk.
      * Melihat detail stok produk dan batas kritis.
  * **Manajemen Transaksi**:
      * Mencatat transaksi penjualan (keluar) dan pengembalian (retur).
      * Melihat daftar transaksi lengkap dengan detail produk, toko, harga, jumlah, tanggal transaksi, dan tanggal retur.
      * Status transaksi ("open" atau "closed").
  * **Manajemen Pemasok**:
      * Menambah, mengedit, dan menghapus data pemasok.
      * Mencatat produk yang disediakan oleh masing-masing pemasok.
  * **Manajemen Toko**:
      * Menambah, mengedit, dan menghapus data toko.
      * Mencatat nama toko, nama pemilik, alamat, dan kontak.
  * **Manajemen Karyawan**:
      * Menambah, mengedit, dan menghapus informasi karyawan (hanya untuk peran Owner).
  * **Laporan**:
      * Filter laporan transaksi berdasarkan periode harian atau bulanan.
      * Ekspor laporan transaksi ke format PDF dan Excel.
  * **Fungsionalitas Pencarian**:
      * Pencarian global di seluruh halaman (transaksi, gudang, pemasok, toko, karyawan, laporan) untuk mempermudah pencarian data.

## Instalasi

Untuk menjalankan aplikasi ini di lingkungan lokal Anda, ikuti langkah-langkah berikut:

1.  **Kloning Repositori:**
    ```bash
    git clone <URL_REPOSITORI_ANDA> PAD-fe
    ```
2.  **Navigasi ke Direktori Proyek:**
    ```bash
    cd PAD-fe
    ```
3.  **Instal Dependensi Composer:**
    ```bash
    composer install
    ```
4.  **Instal Dependensi NPM:**
    ```bash
    npm install
    ```
5.  **Buat File `.env`:**
    ```bash
    cp .env.example .env
    ```
6.  **Konfigurasi Database:**
    Edit file `.env` dan sesuaikan pengaturan database Anda (contoh untuk MySQL):
    ```dotenv
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nama_database_anda
    DB_USERNAME=username_database_anda
    DB_PASSWORD=password_database_anda
    ```
7.  **Jalankan Migrasi Database:**
    Ini akan membuat tabel-tabel yang diperlukan di database Anda.
    ```bash
    php artisan migrate
    ```
8.  **(Opsional) Jalankan Seeder:**
    Untuk mengisi database dengan data awal (pengguna, toko, produk, transaksi, pemasok), Anda bisa menjalankan *seeder*:
    ```bash
    php artisan db:seed
    ```
    *Catatan: Lihat `database/seeders` untuk detail data yang akan dibuat.*
9.  **Generate Kunci Aplikasi:**
    ```bash
    php artisan key:generate
    ```
10. **Jalankan Server Pengembangan Laravel:**
    ```bash
    php artisan serve
    ```
11. **Jalankan Vite untuk Aset (CSS/JS):**
    Buka terminal baru dan jalankan:
    ```bash
    npm run dev
    ```
    Biarkan proses ini berjalan di *background*.

## Penggunaan

Setelah semua langkah instalasi selesai, Anda dapat mengakses aplikasi melalui URL yang diberikan oleh `php artisan serve` (biasanya `http://127.0.0.1:8000`).

  * Gunakan kredensial dari *seeder* (misalnya `isdeaths7@gmail.com` dengan *password* `12345678` untuk *owner*, atau `zaidan@gmail.com` dengan *password* `12345678` untuk *karyawan*) untuk masuk ke dalam aplikasi.
  * Jelajahi fitur-fitur yang tersedia sesuai dengan peran pengguna.

## API Endpoints

Aplikasi ini juga menyediakan *API endpoints* untuk berbagai fungsionalitas manajemen data. Semua *endpoints* API diakses melalui prefiks `/api/` (misalnya `/api/dashboard`, `/api/gudang`, dll.). Detail lebih lanjut dapat ditemukan di *file* `routes/api.php`.

## Teknologi yang Digunakan

  * **Backend**: PHP 8.2+
  * **Framework**: Laravel Framework 10.x
  * **Database**: MySQL (dapat dikonfigurasi untuk PostgreSQL/SQLite)
  * **Frontend**: HTML, CSS (Bootstrap 5), JavaScript (Vanilla JS, jQuery)
  * **Visualisasi Data**: Chart.js
  * **Ekspor Data**: Maatwebsite Excel (untuk `.xlsx`), mPDF (untuk `.pdf`)

## Kontribusi

Kami menyambut kontribusi Anda\! Silakan lihat [panduan kontribusi Laravel](https://laravel.com/docs/contributions) untuk informasi lebih lanjut mengenai cara berkontribusi pada proyek berbasis Laravel.

## Lisensi

Proyek ini dilisensikan di bawah [Lisensi MIT](https://opensource.org/licenses/MIT).
