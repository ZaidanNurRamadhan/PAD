<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate; // Pastikan baris ini tidak ada tanda komentar
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User; // Tambahkan ini untuk mengimpor model User

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Daftarkan Gate untuk melihat dokumentasi API di sini
        Gate::define('viewApiDocs', function (?User $user) {
            // 1. Selalu izinkan jika lingkungan adalah 'local' (untuk pengembangan)
            if (app()->environment('local')) {
                return true;
            }

            // 2. Di lingkungan produksi (VPS), hanya izinkan pengguna yang sudah login
            //    dan memiliki email yang terdaftar di bawah ini.
            //    GANTI 'admin@example.com' dengan email Anda!
            return $user && in_array($user->email, [
                'admin@example.com',
                // 'email.lain@example.com', // Anda bisa tambah email lain di sini
            ]);
        });
    }
}