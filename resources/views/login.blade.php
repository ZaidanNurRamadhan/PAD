<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet"
    />
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous"
    />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/form.css') }}" />
</head>
<body>
    @include('component.notifikasi')
    <main class="container-fluid d-flex align-items-center">
        <div class="row flex-fill">
            <aside class="col-xl-6 col-md-6 d-flex justify-content-center align-items-center">
                <img
                    src="{{ asset('assets/img/WhatsApp Image 2024-09-06 at 14.51.57_79bdcbe2.jpg') }}"
                    alt="logo"
                    class="logo-utama"
                />
            </aside>
            <section
                class="col-xl-6 col-lg-6 col-md-12 col-xm-12 d-flex justify-content-center align-items-center"
            >
                <form id="loginForm" class="login-form" method="POST" action="{{ route('login.submit') }}">
                    @csrf
                    <div class="form-group text-center">
                        <img src="{{ asset('assets/img/logo-konek.png') }}" alt="logo" class="icon-login" />
                        <h1>Login</h1>
                        <p class="fw-light">Selamat datang di aplikasi manajemen stok</p>
                    </div>
                    @error('email')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    <div class="mb-3">
                        <label class="m-0">Email</label>
                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            id="email"
                            placeholder="Masukkan Email"
                            required
                            value="{{ old('email') }}"
                        />
                    </div>
                    <div>
                        <label class="m-0">Password</label>
                        <div class="d-flex position-relative">
                            <input
                                type="password"
                                name="password"
                                class="form-control pe-5"
                                id="password"
                                placeholder="Masukkan Password"
                                required
                            />
                            <span
                                class="position-absolute top-50 end-0 translate-middle-y me-3"
                                onclick="togglePasswordVisibility()"
                                style="cursor: pointer;"
                            >
                                <i id="eyeIcon" class="fas fa-eye"></i>
                            </span>
                        </div>
                    </div>
                    <a href="{{ route('password.forgot') }}" class="mb-2 text-decoration-none float-end">Lupa password?</a>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                    @if(session('error'))
                        <div class="text-danger mt-2">{{ session('error') }}</div>
                    @endif
                </form>
            </section>
        </div>
    </main>
</body>
<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    }
</script>
</html>
