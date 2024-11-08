<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>KONEK - Pemasok</title>
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <aside class="sidebar">
        <div>
            <div class="mb-4 ml-4">
                <img alt="KONEK Logo" height="170" src="{{asset('assets/img/Logo.png')}}" width="170"/>
            </div>
            <nav>
                <a href="{{route('transaksi-karyawan')}}" id="transaksiLink"><i class="fas fa-receipt"></i> Transaksi</a>
                <a href="{{route('gudang-karyawan')}}" id="gudangLink"><i class="fas fa-warehouse"></i> Gudang</a>
            </nav>
        </div>
        <div>
            <nav>
                <a href="#logoutModal" data-bs-toggle="modal" data-bs-target="#logoutModal"><i class="fas fa-sign-out-alt"></i> Keluar</a>
            </nav>
        </div>
    </aside>
    <main class="content">
        <header class="header">
            <input placeholder="Cari produk, laporan, transaksi" type="text"/>
            <div class="karyawan">karyawan</div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
            document.addEventListener("DOMContentLoaded", function() {
        const currentUrl = window.location.href;

        // Daftar elemen link beserta URL-nya
        const links = [
            { element: document.getElementById('gudangLink'), url: "{{ route('gudang-karyawan') }}" },
            { element: document.getElementById('transaksiLink'), url: "{{ route('transaksi-karyawan') }}" }
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
    document.getElementById('confirmLogout').addEventListener('click', function () {
        window.location.href = "{{ route('login') }}"; // Mengarahkan ke halaman login
    });
    </script>
</body>
</html>
