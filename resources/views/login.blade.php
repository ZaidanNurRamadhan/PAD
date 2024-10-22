<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        html,body{
            height: 100%;
            margin: 0;
        }
        img{
            width: 372px;
            height: 372px;
        }
        main{
            min-height: 100vh;
        }
        input,button{
            width: 100%;
        }
        .icon-login{
            width: 100px;
            height: 100px;
        }
        .login-form{
            width: 400px;
        }
        @media (max-width: 768px) {
            aside{
                display: none;
            }
            .logo-utama {
                display: none;
            }
            section{
                width: 100%;
            }
            .container {
                justify-content: center;
            }
            main{
                flex: 1;
            }
        }
        @media (max-width: 1023px) {
            aside{
                display: none;
            }
            .logo-utama {
                display: none;
            }
            section{
                width: 100%;
            }
            .container {
                justify-content: center;
            }
            main{
                flex: 1;
            }
        }
    </style>
</head>
<body>
    <main class="container-fluid d-flex align-items-center">
        <div class="row flex-fill">
            <aside class="col-xl-6 col-md-6 d-flex justify-content-center align-items-center">
                <img src="{{asset('assets/img/WhatsApp Image 2024-09-06 at 14.51.57_79bdcbe2.jpg')}}" alt="logo" class="logo-utama">
            </aside>
            <section class="col-xl-6 col-lg-6 col-md-12 col-xm-12 d-flex justify-content-center align-items-center">
                <form action="post" class="login-form">
                    <div class="form-group text-center">
                        <img src="{{asset('assets/img/logo konek@3x.png')}}" alt="logo" class="icon-login">
                        <h1>Login</h1>
                        <p class="fw-light">Selamat datang di aplikasi manajemen stok</p>
                    </div>
                    <div class="mb-3">
                        <label class="m-0">Username</label>
                        <input type="text" class="form-control" id="username" placeholder="Masukkan Username">
                    </div>
                    <div class="mb-3">
                        <label class="m-0">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Masukkan Password">
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </section>
        </div>
    </main>
</body>
</html>
