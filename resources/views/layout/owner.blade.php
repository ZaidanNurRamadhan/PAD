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
    <aside class="sidebar">
        <div>
            <div>
                <img alt="KONEK Logo" height="170" src="{{asset('assets/img/Logo.png')}}" width="170"/>
            </div>
            <nav>
                <a href="#" class="active"><i class="fas fa-home"></i> Beranda</a>
                <a href="#"><i class="fas fa-warehouse"></i> Gudang</a>
                <a href="#"><i class="fas fa-file-alt"></i> Laporan</a>
                <a href="#"><i class="fas fa-truck"></i> Pemasok</a>
                <a href="#"><i class="fas fa-receipt"></i> Transaksi</a>
                <a href="#"><i class="fas fa-store"></i> Manajemen Toko</a>
            </nav>
        </div>
        <div>
            <nav>
                <a href="#"><i class="fas fa-cog"></i> Settings</a>
                <a href="#"><i class="fas fa-sign-out-alt"></i> Keluar</a>
            </nav>

        </div>
    </aside>
    <main class="content">
        <header class="header">
            <input placeholder="Cari produk, laporan, transaksi" type="text"/>
            <div class="owner">Owner</div>
        </header>
        @yield('content')
    </main>
    <script src="{{ asset('js/sricpt.js') }}"></script>
</body>
</html>
