<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>KONEK - Pemasok</title>
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            background-color: #fff;
            padding-top: 20px;
            border-right: 1px solid #ddd;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 18px;
            color: #333;
            display: block;
        }
        .sidebar a:hover {
            background-color: #f1f1f1;
        }
        .sidebar .active {
            background-color: #e9ecef;
            color: #007bff;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #fff;
            border-bottom: 1px solid #ddd;
        }
        .header input {
            width: 300px;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .header .owner {
            font-weight: bold;
        }
        .table-container {
            margin-top: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            height: calc(100vh - 160px);
            overflow-y: auto;
        }
        .table-container .btn {
            margin-bottom: 10px;
        }
        nav img{
            width: 24px;
            height: 24px;
            margin-right: 10px;
        }
        nav a {
            font-size: 16px;
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div>
            <div class="mb-4 ml-4">
                <img alt="KONEK Logo" height="170" src="{{asset('assets/img/Logo.png')}}" width="170"/>
            </div>
            <nav>
                <a href="#"><img src="{{asset('assets/img/gudang.png')}}" alt="">Gudang</a>
                <a href="#"><img src="{{asset('assets/img/transaksi.png')}}" alt="">Transaksi</a>
            </nav>
        </div>
        <div>
            <nav>
                <a href="#"><img src="{{asset('assets/img/keluar.png')}}" alt="">Keluar</a>
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
</body>
</html>
