<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>KONEK - Pemasok</title>
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>
<body>
    <header class="mobile-header d-md-none d-flex justify-content-between align-items-center p-2 bg-white">
        <button class="navbar-toggler" type="button" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
        <div class="owner">Owner</div>
    </header>
    <aside class="sidebar">
        <div>
            <div>
                <img alt="KONEK Logo" height="170" src="{{asset('assets/img/Logo.png')}}" width="170"/>
            </div>
            <div class="nav-container">
                <nav>
                    <a href="{{route('dashboard')}}" id="dashboardLink"><i class="fas fa-home"></i> Beranda</a>
                    <a href="{{route('gudang-owner')}}" id="gudangLink"><i class="fas fa-warehouse"></i> Gudang</a>
                    <a href="{{route('laporan')}}" id="laporanLink"><i class="fas fa-file-alt"></i> Laporan</a>
                    <a href="{{route('pemasok')}}" id="pemasokLink"><i class="fas fa-truck"></i> Pemasok</a>
                    <a href="{{route('transaksi-owner')}}" id="transaksiLink"><i class="fas fa-receipt"></i> Transaksi</a>
                    <a href="{{route('manajemen-toko')}}" id="tokoLink"><i class="fas fa-store"></i> Manajemen Toko</a>
                </nav>
            </div>
        </div>
        <div>
            <nav>
                <a href="{{route('settings')}}" id="settingsLink"><i class="fas fa-cog"></i> Manajemen Karyawan</a>
                <a href="#logoutModal" data-bs-toggle="modal" data-bs-target="#logoutModal"><i class="fas fa-sign-out-alt"></i> Keluar</a>
            </nav>

        </div>
    </aside>
    <main class="content">
        <header class="header">
            <input placeholder="Cari produk, laporan, transaksi" type="text"/>
            <div class="owner">Owner</div>
        </header>
        <section class="main-content">
            @yield('content')
        </section>
    </main>
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title w-100 text-center" id="logoutModalLabel">Konfirmasi Keluar</h5>
            </div>
            <div class="modal-body text-center">
              Apakah Anda yakin ingin keluar?
            </div>
            <div class="modal-footer justify-content-center">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="button" class="btn btn-danger" id="confirmLogout" href="{{route('login')}}">Keluar</button>
            </div>
          </div>
        </div>
      </div>
    <script src="{{ asset('js/sricpt.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        const navContainers = document.querySelectorAll('.nav-container');

        sidebar.classList.toggle('active');

        navContainers.forEach(container => {
            container.classList.toggle('active');
            });
        }
    document.getElementById('confirmLogout').addEventListener('click', function () {
        window.location.href = "{{ route('login') }}"; // Mengarahkan ke halaman login
    });

    document.addEventListener("DOMContentLoaded", function() {
        const currentUrl = window.location.href;

        // Daftar elemen link beserta URL-nya
        const links = [
            { element: document.getElementById('dashboardLink'), url: "{{ route('dashboard') }}" },
            { element: document.getElementById('gudangLink'), url: "{{ route('gudang-owner') }}" },
            { element: document.getElementById('laporanLink'), url: "{{ route('laporan') }}" },
            { element: document.getElementById('pemasokLink'), url: "{{ route('pemasok') }}" },
            { element: document.getElementById('transaksiLink'), url: "{{ route('transaksi-owner') }}" },
            { element: document.getElementById('tokoLink'), url: "{{ route('manajemen-toko') }}" },
            { element: document.getElementById('settingsLink'), url: "{{route('settings')}}"}
        ];

        // Menetapkan kelas 'active' ke link yang sesuai dengan URL saat ini
        links.forEach(link => {
            if (currentUrl.includes(link.url)) {
                link.element.classList.add('active');
            } else {
                link.element.classList.remove('active');
            }
        });
    });
    </script>

</body>
</html>
