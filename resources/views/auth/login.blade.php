<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        /* Responsive tweaks for login */
        .login-card {
            max-width: 400px;
        }

        .login-icon {
            width: 60px;
            height: 60px;
        }

        .login-icon i {
            font-size: 1.25rem;
        }

        @media (max-width: 480px) {
            .login-card {
                max-width: 340px;
            }

            .login-icon {
                width: 48px;
                height: 48px;
            }

            .login-icon i {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body class="bg-light">

    <div class="container min-vh-100 d-flex justify-content-center align-items-center py-4">
        <div class="card shadow-sm w-100 login-card">
            <div
                class="d-flex justify-content-center align-items-center bg-primary text-white rounded-circle mx-auto mb-0 mt-3 login-icon">
                <i class="bi bi-building"></i>
            </div>

            <div class="text-center text-dark mt-3">
                <p class="mb-0 fw-bold">Sistem Manajemen Leasing</p>
                <p>Masuk ke akun Anda untuk melanjutkan</p>
            </div>

            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form action="{{ route('login.process') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="nama@contoh.com"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Kata Sandi</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Masukkan kata sandi Anda" required>
                            <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                <i class="bi bi-eye-slash"></i>
                            </span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-dark w-100">Masuk</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            const icon = this.querySelector('i');
            icon.classList.toggle('bi-eye');
            icon.classList.toggle('bi-eye-slash');
        });
    </script>

</body>

</html>