<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Akun - Toko Syfa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Mengikuti tema gradasi gelap premium sesuai layout register */
        body {
            background: radial-gradient(circle at 10% 20%, #032b30 0%, #05171a 40%, #020b0d 100%);
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .login-container {
            background: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            max-width: 440px;
            width: 100%;
            border: 1px solid rgba(255, 255, 255, 0.05);
            padding: 45px;
        }

        .form-control {
            background-color: #ffffff;
            border: 1px solid #dcdcdc;
            padding: 11px 16px;
            border-radius: 8px;
            font-size: 0.95rem;
            color: #333333;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            background-color: #ffffff;
            border-color: #032b30;
            box-shadow: 0 0 0 4px rgba(3, 43, 48, 0.1);
        }

        .btn-submit-custom {
            background-color: #111111;
            color: #ffffff;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: background-color 0.2s ease;
        }

        .btn-submit-custom:hover {
            background-color: #032b30;
            color: #ffffff;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="text-center mb-4">
            <h2 class="fw-bold text-dark text-uppercase mb-1" style="letter-spacing: 1px;">TOKO SYFA</h2>
            <p class="text-muted small">Silakan masuk menggunakan akun demo Anda</p>
        </div>
        
        @if(session('success'))
            <div class="alert alert-success bg-light text-success border-0 small mb-4 text-center py-2 rounded-3">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="/login">
            @csrf
            
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email address" required>
            </div>

            <div class="mb-4">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <button type="submit" class="btn btn-submit-custom w-100 text-uppercase shadow-sm">
                Sign In
            </button>
        </form>

        <p class="text-center small text-muted mt-4 mb-0">
            Belum punya akun? <a href="/register" class="text-decoration-none fw-bold text-dark">Daftar di sini</a>
        </p>
    </div>

</body>
</html>