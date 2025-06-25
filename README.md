<p align="center">
  <img src="https://raw.githubusercontent.com/zaidannurramadhan/pad/main/public/assets/img/Logo.png" alt="Logo KONEK" width="400">
</p>

# KONEK - Aplikasi Manajemen Stok

KONEK adalah aplikasi manajemen stok berbasis web yang dibangun dengan framework Laravel. Aplikasi ini dirancang untuk menyediakan solusi yang intuitif dan efisien dalam mengelola inventaris produk, transaksi penjualan, pemasok, dan data toko. KONEK menawarkan berbagai tingkat akses untuk pemilik dan karyawan, memastikan operasional yang lancar dan pengawasan yang jelas terhadap aktivitas bisnis.

## Fitur

**Untuk Pemilik:**
* **Dashboard**: Dapatkan gambaran umum distribusi produk, penjualan, pengembalian, produk terlaris, dan tingkat stok kritis.
* **Manajemen Transaksi**: Lihat, tambah, edit, dan hapus transaksi penjualan dan pengembalian.
* **Manajemen Gudang**: Kelola inventaris produk, termasuk menambah produk baru, mengedit yang sudah ada, dan menghapus catatan. Lacak stok produk, harga beli, harga jual, dan ambang batas stok kritis.
* **Laporan**: Buat laporan harian dan bulanan untuk transaksi dalam format PDF dan Excel.
* **Manajemen Pemasok**: Pertahankan daftar pemasok, termasuk nama, produk yang disediakan, nomor kontak, dan email mereka.
* **Manajemen Toko**: Kelola informasi tentang toko, seperti nama toko, nama pemilik, alamat, dan nomor telepon.
* **Manajemen Karyawan**: Tambah, edit, dan hapus akun karyawan dengan peran tertentu.

**Untuk Karyawan:**
* **Manajemen Transaksi**: Catat penjualan dan pengembalian baru.
* **Lihat Gudang**: Lihat stok produk saat ini dan tingkat kritis.

## Teknologi yang Digunakan

* **Laravel**: Framework aplikasi web yang menyediakan struktur backend dan endpoint API.
* **Composer**: Manajer dependensi untuk PHP.
* **MySQL**: Sistem manajemen database untuk menyimpan data aplikasi.
* **Bootstrap**: Framework frontend untuk komponen UI yang responsif dan modern.
* **JavaScript (Fetch API, jQuery)**: Untuk dynamic content loading dan interaction dengan endpoint API.
* **Chart.js**: Untuk menampilkan interactive data visualizations di dashboard.
* **Maatwebsite/Excel**: Untuk mengekspor data transaksi ke Excel.
* **Mpdf/Mpdf**: Untuk menghasilkan laporan PDF.

## Instalasi dan Pengaturan

Untuk mendapatkan salinan KONEK agar dapat berjalan di mesin lokal Anda untuk tujuan pengembangan dan pengujian, ikuti langkah-langkah berikut:

### Prasyarat

* PHP >= 8.2
* Composer
* Node.js & npm (atau Yarn)
* MySQL (atau database lain yang didukung oleh Laravel)

### Langkah-langkah

1.  **Clone the repository:**
    ```bash
    git clone [https://github.com/zaidannurramadhan/pad.git](https://github.com/zaidannurramadhan/pad.git)
    cd pad
    ```

2.  **Install PHP dependencies:**
    ```bash
    composer install
    ```
    * **Note**: If `dedoc/scramble` is causing issues, you might need to run `composer update --no-dev` or manually remove it from `composer.json` for production, although it's a dev dependency.

3.  **Install JavaScript dependencies:**
    ```bash
    npm install
    # ATAU
    yarn install
    ```

4.  **Create and configure your `.env` file:**
    ```bash
    cp .env.example .env
    ```
    Open `.env` and configure your database connection and other environment variables.
    ```
    APP_NAME=Laravel
    APP_ENV=local
    APP_KEY=
    APP_URL=http://localhost

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=konek_db # Ganti dengan nama database Anda
    DB_USERNAME=root     # Ganti dengan nama pengguna database Anda
    DB_PASSWORD=         # Ganti dengan kata sandi database Anda
    ```

5.  **Generate application key:**
    ```bash
    php artisan key:generate
    ```

6.  **Run database migrations and seeders:**
    ```bash
    php artisan migrate
    php artisan db:seed # Ini akan menjalankan semua seeders, termasuk akun pengguna awal, produk, transaksi, dan pemasok.
    ```
    * **Catatan:** `LoginSeeder.php` membuat dua pengguna default:
        * **Pemilik:** `email: isdeaths7@gmail.com`, `kata sandi: 12345678`
        * **Karyawan:** `email: zaidan@gmail.com`, `kata sandi: 12345678`

7.  **Link storage (untuk file yang dapat diakses publik):**
    ```bash
    php artisan storage:link
    ```

8.  **Compile frontend assets:**
    ```bash
    npm run dev
    # ATAU
    yarn dev
    ```
    Untuk production:
    ```bash
    npm run build
    # ATAU
    yarn build
    ```

9.  **Jalankan aplikasi:**
    ```bash
    php artisan serve
    ```
    Aplikasi biasanya akan tersedia di `http://localhost:8000`.

## Dokumentasi API

Proyek ini menggunakan `dedoc/scramble` untuk dokumentasi API.
Anda dapat melihat dokumentasi API dengan menavigasi ke `/docs/api` setelah menjalankan aplikasi.

**Kontrol Akses untuk Dokumen API:**
* Di lingkungan `local`, dokumentasi API selalu dapat diakses.
* Di lingkungan `production` (VPS), hanya user yang masuk dengan alamat email tertentu (didefinisikan di `App\Providers\AuthServiceProvider.php`) yang dapat melihat dokumentasi. Anda harus mengubah `'admin@example.com'` ke email admin Anda yang sebenarnya.

## Sorotan Struktur Proyek

* `app/Http/Controllers`: Berisi logika aplikasi, dipisahkan menjadi `Api` dan kontroler web.
    * `Api/DashboardController.php`: Menangani data dashboard, termasuk penjualan, pengembalian, stok kritis, dan produk terlaris.
    * `Api/GudangController.php`: Mengelola data produk (gudang) melalui API.
    * `Api/LaporanController.php`: Menyediakan endpoint API untuk laporan dan ekspor PDF.
    * `Api/MonitoringController.php`: Menangani data pemantauan, khususnya untuk transaksi "terbuka".
    * `Api/PemasokController.php`: Mengelola data pemasok melalui API.
    * `Api/SettingController.php`: Mengelola akun user karyawan melalui API.
    * `Api/TokoController.php`: Mengelola data toko melalui API.
    * `Api/TransaksiController.php`: Mengelola data transaksi melalui API untuk pemilik dan karyawan.
* `app/Models`: Model Eloquent untuk interaksi database (misalnya, `Produk`, `Pemasok`, `Toko`, `Transaksi`, `User`).
* `database/migrations`: Mendefinisikan skema database. Tabel utama termasuk `users`, `produk`, `toko`, `transaksi`, dan `pemasok`.
* `database/seeders`: Mengisi database dengan data awal (misalnya, `LoginSeeder`, `ProdukSeeder`, `PemasokSeeder`, `TokoSeeder`, `TransaksiSeeder`).
* `resources/views`: Template Blade untuk interface user.
    * `layout/owner.blade.php`: Main layout untuk user pemilik, termasuk navigasi dan fungsionalitas pencarian.
    * `layout/karyawan.blade.php`: Main layout untuk user karyawan.
    * `login.blade.php`: Halaman login user.
    * `dashboard.blade.php`: Dashboard pemilik menampilkan berbagai statistik dan grafik.
    * `gudang-owner.blade.php`: Interface manajemen gudang untuk pemilik.
    * `transaksi-owner.blade.php`: Interface manajemen transaksi untuk pemilik.
    * `laporan.blade.php`: Interface pelaporan untuk pemilik.
    * `pemasok.blade.php`: Interface manajemen pemasok.
    * `manajemen-toko.blade.php`: Interface manajemen toko.
    * `settings.blade.php`: Interface manajemen karyawan.
* `public/css` dan `public/js`: File CSS dan JavaScript kustom untuk penataan gaya dan logika sisi client.
    * `public/js/script.js`: Berisi fungsi JavaScript umum untuk modal, pencarian, dan interaksi API.
* `routes/api.php`: Mendefinisikan rute API untuk modul yang berbeda, dilindungi oleh Sanctum dan middleware berbasis role.
* `routes/web.php`: Mendefinisikan rute web untuk navigasi halaman dan authentication.

## Catatan Penting

* **Authentication**: Aplikasi ini menggunakan Laravel Sanctum untuk Authentication berbasis token API. Saat masuk melalui web, token disimpan di penyimpanan lokal untuk permintaan API berikutnya.
* **Error Handling**: Error handling kustom diterapkan untuk mengembalikan respons JSON untuk permintaan API.
* **Reset Kata Sandi**: Fungsionalitas untuk "Lupa Kata Sandi" dan "Reset Kata Sandi" diterapkan, mengirim token email untuk verifikasi.
* **Environment**: Aplikasi ini membedakan antara environments `local` dan `production`, yang memengaruhi fitur seperti akses dokumentasi API.

## Berkontribusi

Kontribusi sangat disambut! Silakan ajukan isu atau kirimkan pull request.

## Lisensi

Proyek ini adalah perangkat lunak open-source yang dilisensikan di bawah [lisensi MIT](https://opensource.org/licenses/MIT).
