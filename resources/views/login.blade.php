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
                <form id="loginForm" class="login-form">
                    @csrf
                    <div class="form-group text-center">
                        <img src="{{ asset('assets/img/logo-konek.png') }}" alt="logo" class="icon-login" />
                        <h1>Login</h1>
                        <p class="fw-light">Selamat datang di aplikasi manajemen stok</p>
                    </div>
                    <div class="mb-3">
                        <label class="m-0">Email</label>
                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            id="email"
                            placeholder="Masukkan Email"
                            required
                        />
                    </div>
                    <div>
                        <label class="m-0">Password</label>
                        <div class="d-flex">
                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                id="password"
                                placeholder="Masukkan Password"
                                required
                            />
                        </div>
                    </div>
                    <a href="{{ route('password.forgot') }}" class="mb-2 text-decoration-none float-end">Lupa password?</a>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                    <div id="loginError" class="text-danger mt-2" style="display:none;"></div>
                </form>
            </section>
        </div>
    </main>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function (event) {
            event.preventDefault();

            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();
            const loginError = document.getElementById('loginError');
            loginError.style.display = 'none';
            loginError.textContent = '';

            fetch('http://127.0.0.1:8000/api/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ email: email, password: password }),
            })
                .then((response) => {
                    if (!response.ok) {
                        return response.json().then((data) => {
                            throw new Error(data.message || 'Login failed');
                        });
                    }
                    return response.json();
                })
            .then((data) => {
                // Save token to localStorage or cookie if needed
                localStorage.setItem('authToken', data.token);

                // Redirect based on user role
                if (data.user && data.user.role) {
                    if (data.user.role === 'owner') {
                        window.location.href = '/dashboard-owner';
                    } else if (data.user.role === 'karyawan') {
                        window.location.href = '/transaksi-karyawan';
                    } else {
                        window.location.href = '/dashboard';
                    }
                } else {
                    window.location.href = '/dashboard';
                }
            })
            .catch((error) => {
                loginError.style.display = 'block';
                loginError.textContent = error.message;
            });
        });
    </script>
</body>
</html>
