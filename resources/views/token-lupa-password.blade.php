<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('css/form.css')}}">
</head>
<body>
    @include('component.notifikasi')
    <main class="container-fluid d-flex align-items-center">
        <div class="row flex-fill">
            <aside class="col-xl-6 col-md-6 d-flex justify-content-center align-items-center">
                <img src="{{asset('assets/img/WhatsApp Image 2024-09-06 at 14.51.57_79bdcbe2.jpg')}}" alt="logo" class="logo-utama">
            </aside>
            <section class="col-xl-6 col-lg-6 col-md-12 col-xm-12 d-flex justify-content-center align-items-center">
                <form id="validate-token-form" class="login-form">
                    @csrf
                    <div class="form-group text-center">
                        <img src="{{ asset('assets/img/logo-konek.png') }}" alt="logo" class="icon-login">
                        <h1>Verifikasi Kode</h1>
                        <p class="fw-light mb-0">Masukkan kode yang diterima di email Anda</p>
                    </div>
                    {{-- <input type="hidden" name="email" value="{{ $email }}"> --}}
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="mb-3">
                        <label class="m-0" for="token">Masukkan kode verifikasi</label>
                        <input type="text" name="token" class="form-control" id="token" placeholder="Masukkan Kode Verifikasi" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                </form>
                <script>
                    document.getElementById('validate-token-form').addEventListener('submit', async function(e) {
                        e.preventDefault();
                        const email = localStorage.getItem('resetEmail');
                        const tokenInput = document.getElementById('token').value;

                        try {
                            const response = await fetch('{{ url('api/validate-token') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({ email: email, token: tokenInput })
                            });

                            const data = await response.json();

                            if (response.ok && data.success) {
                                window.location.href = '{{ url('/reset-password') }}';
                            } else {
                                alert(data.message || 'Terjadi kesalahan, silakan coba lagi.');
                            }
                        } catch (error) {
                            alert('Terjadi kesalahan jaringan, silakan coba lagi.');
                        }
                    });
                </script>
            </section>
        </div>
    </main>
</body>
</html>
