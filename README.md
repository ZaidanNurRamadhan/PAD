<p align="center">
  <img src="https://raw.githubusercontent.com/zaidannurramadhan/pad/main/public/assets/img/Logo.png" alt="Logo KONEK" width="400">
</p>

# KONEK - Aplikasi Manajemen Stok

KONEK adalah aplikasi manajemen stok berbasis web yang dibangun dengan framework Laravel. Aplikasi ini dirancang untuk menyediakan solusi yang intuitif dan efisien dalam mengelola inventaris produk, transaksi penjualan, pemasok, dan data toko. KONEK menawarkan berbagai tingkat akses untuk pemilik dan karyawan, memastikan operasional yang lancar dan pengawasan yang jelas terhadap aktivitas bisnis.

## Fitur

**Untuk Pemilik:**
* **Dasbor**: Dapatkan gambaran umum distribusi produk, penjualan, pengembalian, produk terlaris, dan tingkat stok kritis.
* **Manajemen Transaksi**: Lihat, tambah, edit, dan hapus transaksi penjualan dan pengembalian.
* **Manajemen Gudang**: Kelola inventaris produk, termasuk menambah produk baru, mengedit yang sudah ada, dan menghapus catatan. Lacak stok produk, harga beli, harga jual, dan ambang batas stok kritis.
* **Pelaporan**: Buat laporan harian dan bulanan untuk transaksi dalam format PDF dan Excel.
* **Manajemen Pemasok**: Pertahankan daftar pemasok, termasuk nama, produk yang disediakan, nomor kontak, dan email mereka.
* **Manajemen Toko**: Kelola informasi tentang toko Anda, seperti nama toko, nama pemilik, alamat, dan nomor telepon.
* **Manajemen Karyawan**: Tambah, edit, dan hapus akun karyawan dengan peran tertentu.

**Untuk Karyawan:**
* **Manajemen Transaksi**: Catat penjualan dan pengembalian baru.
* **Lihat Gudang**: Lihat stok produk saat ini dan tingkat kritis.

## Teknologi yang Digunakan

* **Laravel**: Framework aplikasi web yang menyediakan struktur backend dan endpoint API.
* **Composer**: Manajer dependensi untuk PHP.
* **MySQL**: Sistem manajemen database untuk menyimpan data aplikasi.
* **Bootstrap**: Framework frontend untuk komponen UI yang responsif dan modern.
* **JavaScript (Fetch API, jQuery)**: Untuk pemuatan konten dinamis dan interaksi dengan endpoint API.
* **Chart.js**: Untuk menampilkan visualisasi data interaktif di dasbor.
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

1.  **Kloning repositori:**
    ```bash
    git clone [https://github.com/zaidannurramadhan/pad.git](https://github.com/zaidannurramadhan/pad.git)
    cd pad
    ```

2.  **Instal dependensi PHP:**
    ```bash
    composer install
    ```
    * **Catatan**: Jika `dedoc/scramble` menyebabkan masalah, Anda mungkin perlu menjalankan `composer update --no-dev` atau menghapusnya secara manual dari `composer.json` untuk produksi, meskipun itu adalah dependensi dev.

3.  **Instal dependensi JavaScript:**
    ```bash
    npm install
    # ATAU
    yarn install
    ```

4.  **Buat dan konfigurasikan file `.env` Anda:**
    ```bash
    cp .env.example .env
    ```
    Buka `.env` dan konfigurasikan koneksi database Anda serta variabel lingkungan lainnya.
    ```
    APP_NAME="KONEK"
    APP_ENV=local
    APP_KEY=
    APP_URL=http://localhost:8000

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=konek_db # Ganti dengan nama database Anda
    DB_USERNAME=root     # Ganti dengan nama pengguna database Anda
    DB_PASSWORD=         # Ganti dengan kata sandi database Anda
    ```

5.  **Hasilkan kunci aplikasi:**
    ```bash
    php artisan key:generate
    ```

6.  **Jalankan migrasi database dan seeders:**
    ```bash
    php artisan migrate
    php artisan db:seed # Ini akan menjalankan semua seeders, termasuk akun pengguna awal, produk, transaksi, dan pemasok.
    ```
    * **Catatan:** `LoginSeeder.php` membuat dua pengguna default:
        * **Pemilik:** `email: isdeaths7@gmail.com`, `kata sandi: 12345678`
        * **Karyawan:** `email: zaidan@gmail.com`, `kata sandi: 12345678`

7.  **Tautkan penyimpanan (untuk file yang dapat diakses publik):**
    ```bash
    php artisan storage:link
    ```

8.  **Kompilasi aset frontend:**
    ```bash
    npm run dev
    # ATAU
    yarn dev
    ```
    Untuk produksi:
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
* Di lingkungan `production` (VPS), hanya pengguna yang masuk dengan alamat email tertentu (didefinisikan di `App\Providers\AuthServiceProvider.php`) yang dapat melihat dokumentasi. Anda harus mengubah `'admin@example.com'` ke email admin Anda yang sebenarnya.

## Sorotan Struktur Proyek

* `app/Http/Controllers`: Berisi logika aplikasi, dipisahkan menjadi `Api` dan kontroler web.
    * `Api/DashboardController.php`: Menangani data dasbor, termasuk penjualan, pengembalian, stok kritis, dan produk terlaris.
    * `Api/GudangController.php`: Mengelola data produk (gudang) melalui API.
    * `Api/LaporanController.php`: Menyediakan endpoint API untuk laporan dan ekspor PDF.
    * `Api/MonitoringController.php`: Menangani data pemantauan, khususnya untuk transaksi "terbuka".
    * `Api/PemasokController.php`: Mengelola data pemasok melalui API.
    * `Api/SettingController.php`: Mengelola akun pengguna karyawan melalui API.
    * `Api/TokoController.php`: Mengelola data toko melalui API.
    * `Api/TransaksiController.php`: Mengelola data transaksi melalui API untuk pemilik dan karyawan.
* `app/Models`: Model Eloquent untuk interaksi database (misalnya, `Produk`, `Pemasok`, `Toko`, `Transaksi`, `User`).
* `database/migrations`: Mendefinisikan skema database. Tabel utama termasuk `users`, `produk`, `toko`, `transaksi`, dan `pemasok`.
* `database/seeders`: Mengisi database dengan data awal (misalnya, `LoginSeeder`, `ProdukSeeder`, `PemasokSeeder`, `TokoSeeder`, `TransaksiSeeder`).
* `resources/views`: Template Blade untuk antarmuka pengguna.
    * `layout/owner.blade.php`: Tata letak utama untuk pengguna pemilik, termasuk navigasi dan fungsionalitas pencarian.
    * `layout/karyawan.blade.php`: Tata letak utama untuk pengguna karyawan.
    * `login.blade.php`: Halaman login pengguna.
    * `dashboard.blade.php`: Dasbor pemilik menampilkan berbagai statistik dan grafik.
    * `gudang-owner.blade.php`: Antarmuka manajemen gudang untuk pemilik.
    * `transaksi-owner.blade.php`: Antarmuka manajemen transaksi untuk pemilik.
    * `laporan.blade.php`: Antarmuka pelaporan untuk pemilik.
    * `pemasok.blade.php`: Antarmuka manajemen pemasok.
    * `manajemen-toko.blade.php`: Antarmuka manajemen toko.
    * `settings.blade.php`: Antarmuka manajemen karyawan.
* `public/css` dan `public/js`: File CSS dan JavaScript kustom untuk penataan gaya dan logika sisi klien.
    * `public/js/script.js`: Berisi fungsi JavaScript umum untuk modal, pencarian, dan interaksi API.
* `routes/api.php`: Mendefinisikan rute API untuk modul yang berbeda, dilindungi oleh Sanctum dan middleware berbasis peran.
* `routes/web.php`: Mendefinisikan rute web untuk navigasi halaman dan otentikasi.

## Catatan Penting

* **Otentikasi**: Aplikasi ini menggunakan Laravel Sanctum untuk otentikasi berbasis token API. Saat masuk melalui web, token disimpan di penyimpanan lokal untuk permintaan API berikutnya.
* **Penanganan Kesalahan**: Penanganan kesalahan kustom diterapkan untuk mengembalikan respons JSON untuk permintaan API.
* **Reset Kata Sandi**: Fungsionalitas untuk "Lupa Kata Sandi" dan "Reset Kata Sandi" diterapkan, mengirim token email untuk verifikasi.
* **Lingkungan**: Aplikasi ini membedakan antara lingkungan `local` dan `production`, yang memengaruhi fitur seperti akses dokumentasi API.

## Berkontribusi

Kontribusi sangat disambut! Silakan ajukan isu atau kirimkan pull request.

## Lisensi

Proyek ini adalah perangkat lunak open-source yang dilisensikan di bawah [lisensi MIT](https://opensource.org/licenses/MIT).
