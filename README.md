# Sistem Manajemen Stok KONEK - Backend

Selamat datang di repositori backend untuk aplikasi Sistem Manajemen Stok KONEK. Aplikasi ini dirancang untuk membantu pemilik dan karyawan toko dalam mengelola stok produk, melacak transaksi, memantau pergerakan produk, dan menghasilkan laporan.

## Fitur Utama

Aplikasi backend ini menyediakan fungsionalitas komprehensif untuk manajemen inventaris:

  * **Autentikasi Pengguna:** Sistem login yang aman dengan pemisahan peran untuk `owner` dan `karyawan`.
  * **Manajemen Dashboard:**
      * Pemantauan penyebaran produk secara real-time.
      * Grafik penjualan dan retur yang dapat difilter (harian/bulanan).
      * Daftar produk terlaris.
      * Notifikasi produk dengan stok menipis.
  * **Manajemen Transaksi:**
      * Pencatatan transaksi penjualan produk ke toko.
      * Fungsionalitas untuk menambahkan, mengedit, dan melihat detail transaksi.
      * Penyesuaian stok otomatis berdasarkan jumlah produk yang dibeli dan diretur.
  * **Manajemen Gudang:**
      * Pencatatan dan pengelolaan informasi produk yang ada di gudang.
      * Melacak harga beli, harga jual, jumlah stok, dan batas kritis produk.
      * Fungsionalitas tambah, edit, dan hapus produk.
  * **Manajemen Laporan:**
      * Melihat rekap transaksi berdasarkan filter waktu (harian/bulanan).
      * Ekspor laporan transaksi dalam format PDF dan Excel.
      * Informasi mengenai jumlah transaksi, produk terjual, dan produk retur.
  * **Manajemen Pemasok:**
      * Mengelola daftar pemasok, termasuk nama, produk yang disediakan, kontak, dan email.
      * Fungsionalitas tambah, edit, dan hapus data pemasok.
  * **Manajemen Toko:**
      * Mengelola informasi detail toko seperti nama toko, nama pemilik, alamat, dan nomor telepon.
      * Fungsionalitas tambah, edit, dan hapus data toko.
  * **Manajemen Karyawan (Pengaturan):**
      * Menambahkan, mengedit, dan menghapus data karyawan (pengguna dengan peran `karyawan`).
      * Mengelola detail karyawan seperti nama, kontak, dan email.
  * **Pencarian Global:** Fitur pencarian terintegrasi untuk memudahkan pencarian data di berbagai modul seperti transaksi, gudang, pemasok, toko, dan karyawan.
  * **Sistem Reset Password:** Alur untuk reset password melalui email menggunakan token verifikasi.

## Teknologi yang Digunakan

Proyek ini dibangun dengan kombinasi teknologi backend dan frontend yang robust:

  * **Backend Framework:** Laravel 10 (PHP 8.2+).
  * **Database:** MySQL.
  * **API Authentication:** Laravel Sanctum.
  * **Asset Bundling:** Vite.
  * **Dependensi PHP:**
      * `dedoc/scramble`: Untuk dokumentasi API.
      * `maatwebsite/excel`: Untuk ekspor data ke Excel.
      * `mpdf/mpdf`: Untuk ekspor data ke PDF.
      * `guzzlehttp/guzzle`: HTTP client.
  * **Dependensi JavaScript:**
      * Axios: HTTP client.
      * Chart.js: Untuk visualisasi data grafik.
      * jQuery: Untuk manipulasi DOM dan AJAX.
      * Bootstrap 5: Kerangka kerja CSS untuk desain responsif.
  * **Environment Management:** PHPUnit untuk testing.

## Instalasi Proyek

Untuk menjalankan proyek ini di lingkungan lokal Anda, ikuti langkah-langkah di bawah ini:

1.  **Clone Repositori:**
    ```bash
    git clone https://github.com/zaidannurramadhan/pad.git
    cd pad/PAD-revert-4-be
    ```
2.  **Instal Dependensi Composer:**
    ```bash
    composer install
    ```
3.  **Instal Dependensi Node.js:**
    ```bash
    npm install
    ```
4.  **Konfigurasi Environment:**
      * Buat salinan file `.env.example` dan ganti namanya menjadi `.env`:
        ```bash
        cp .env.example .env
        ```
      * Buka file `.env` dan konfigurasikan detail database Anda (DB\_CONNECTION, DB\_HOST, DB\_PORT, DB\_DATABASE, DB\_USERNAME, DB\_PASSWORD).
5.  **Generate Application Key:**
    ```bash
    php artisan key:generate
    ```
6.  **Jalankan Migrasi Database:**
    ```bash
    php artisan migrate
    ```
7.  **Jalankan Seeder Database (Opsional, untuk data dummy):**
    ```bash
    php artisan db:seed
    ```
    Ini akan mengisi database dengan data awal termasuk akun `owner` dan `karyawan`.
8.  **Jalankan Server Pengembangan Laravel:**
    ```bash
    php artisan serve
    ```
9.  **Jalankan Vite Development Server:**
    ```bash
    npm run dev
    ```
    Pastikan kedua server ini berjalan secara bersamaan.

## Penggunaan

Setelah instalasi, Anda dapat mengakses aplikasi melalui *web browser* Anda.

### Kredensial Login Default:

Anda dapat login sebagai `owner` atau `karyawan` menggunakan kredensial berikut (jika Anda menjalankan `php artisan db:seed`):

  * **Owner:**
      * Email: `isdeaths7@gmail.com`
      * Password: `12345678`
  * **Karyawan:**
      * Email: `zaidan@gmail.com`
      * Password: `12345678`

Setelah berhasil login, Anda akan diarahkan ke dashboard atau halaman transaksi sesuai dengan peran pengguna.

## Lisensi

Proyek ini dilisensikan di bawah [Lisensi MIT](https://opensource.org/licenses/MIT).

## Kontribusi

Kontribusi sangat dihargai\! Silakan merujuk ke [panduan kontribusi Laravel](https://laravel.com/docs/contributions) untuk informasi lebih lanjut tentang cara berkontribusi pada proyek.
