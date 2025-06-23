<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>KONEK - Stock App</title>
    <link rel="icon" href="{{ asset('assets/img/logo-konek.png') }}" type="image/x-icon" sizes="192x192">
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/layout.css')}}">
</head>
<body data-page="{{ request()->segment(1) }}">
    <aside class="sidebar">
        <div>
            <div>
                <img alt="KONEK Logo" height="120" src="{{ asset('assets/img/Logo.png') }}" width="170" class="image1 object-fit-cover"/>
                <img alt="KONEK Logo" height="80" src="{{ asset('assets/img/logo-konek.png') }}" width="80" class="image2"/>
            </div>
            <nav>
                <a href="{{route('transaksi-karyawan')}}" id="transaksiLink" class="mb-2"><i class="fas fa-receipt"></i><i class="d-none lg d-lg-inline fst-normal"> Transaksi</i></a>
                <a href="{{route('gudang-karyawan')}}" id="gudangLink" class="mb-2"><i class="fas fa-warehouse"></i><i class="d-none lg d-lg-inline fst-normal"> Gudang</i></a>
            </nav>
        </div>
        <div>
            <nav>
                <a href="#logoutModal" data-bs-toggle="modal" data-bs-target="#logoutModal" class="text-decoration-none fst-normal"><i class="fas fa-sign-out-alt"></i><i class="d-none lg d-md-inline fst-normal"> Keluar</i></a>
            </nav>
        </div>
    </aside>

    <main id="app"
          class="content"
          data-routes="{{ json_encode([
              'transaksi' => route('transaksi-karyawan'),
              'gudang' => route('gudang-karyawan')
          ]) }}">
        <header class="d-sm-none">
            <nav class="navbar bg-body-tertiary fixed-top">
                <div class="container-fluid">
                  <img src="{{asset('assets/img/Logo.png')}}" width="100" height="40" class="aspek object-fit-cover" alt="">
                  <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                    <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                      <h5 class="offcanvas-title fs-3" id="offcanvasNavbarLabel">Menu</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body d-flex flex-column">
                        <ul class="navbar-nav flex-grow-1">
                          <li class="nav-item">
                            <a href="{{ route('transaksi-karyawan') }}" id="transaksiLink" class="text-decoration-none fst-normal {{ request()->routeIs('transaksi-karyawan') ? 'active' : '' }}">
                              <i class="fas fa-receipt"></i><i class="d-none lg d-lg-inline fst-normal"> Transaksi</i>
                            </a>
                          </li>
                          <li class="nav-item">
                            <a href="{{ route('gudang-karyawan') }}" id="gudangLink" class="text-decoration-none fst-normal {{ request()->routeIs('gudang-karyawan') ? 'active' : '' }}"><i class="fas fa-warehouse"></i><i class="d-none lg d-lg-inline fst-normal"> Gudang</i></a>
                          </li>

                          <!-- Bagian bawah dengan `mt-auto` agar berada di bagian paling bawah -->
                          <li class="nav-item mt-auto">
                            <a href="#logoutModal" data-bs-toggle="modal" data-bs-target="#logoutModal" class="text-decoration-none fst-normal"><i class="fas fa-sign-out-alt"></i><i class="d-none lg d-md-inline fst-normal"> Keluar</i></a>
                          </li>
                        </ul>
                      </div>

                  </div>
                </div>
              </nav>
        </header>
        <section class="header">
            <input type="text" name="search" id="search" placeholder="Search..." class="form-control"/>
            <div class="karyawan">Karyawan</div>
        </section>
        <section class="main-content">
            @yield('content')
        </section>
    </main>

    @if(session('token'))
    <script>
        localStorage.setItem('authToken', "{{ session('token') }}");
    </script>
    @endif

    @include('component.ModalKeluar')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="{{asset('js/script.js')}}"></script>
    <script src="{{asset('js/layout-karyawan.js')}}"></script>
    <script>
        $(document).on('keyup', '#search', function(e) {
            e.preventDefault();
            let search_string = $('#search').val(); // Ambil nilai pencarian
            let page = $('body').data('page');  // Ambil data halaman aktif (toko, transaksi, laporan)

            console.log('Search String: ', search_string);
            console.log('Page: ', page);

            if (search_string.length < 1) {
                return;  // Jangan melakukan pencarian jika input kosong
            }

            $.ajax({
                url: "{{ url('/api/search') }}",  // URL ke controller untuk pencarian
                method: 'GET',
                data: {
                    search: search_string,
                    page: page // Kirimkan kata kunci pencarian
                },
                success: function(res) {
                    // console.log('Search Results:', res);
                    // Update hasil pencarian hanya di dalam <tbody> (area yang relevan)
                    $('.table-data tbody').html(res);  // Update hasil pencarian di dalam tabel
                    //applyDeleteListeners(); Fungsi untuk menerapkan event listener pada tombol delete

                },
                error: function(xhr, status, error) {
                    console.error('AJAX error: ' + error);  // Debugging jika terjadi kesalahan
                }
            });
        });
    </script>
    <script>
document.addEventListener('DOMContentLoaded', () => {
    const logoutBtn = document.getElementById('logoutBtn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', () => {
            const token = localStorage.getItem('authToken');
            if (!token) {
                alert('User not authenticated.');
                return;
            }
            fetch('/api/logout', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (response.ok) {
                    localStorage.removeItem('authToken');
                } else {
                    alert('Logout failed.');
                }
            })
            .catch(() => {
                alert('Logout failed.');
            });
        });
    }
});
</script>
</body>
</html>
