<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Akun Baru - Toko Syfa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Latar belakang halaman menggunakan gradasi sesuai image_1ed3c3.jpg */
        body {
            background: radial-gradient(circle at 10% 20%, #032b30 0%, #05171a 40%, #020b0d 100%);
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        /* Container utama card split dua kolom */
        .register-container {
            background: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            max-width: 960px;
            width: 100%;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Banner kolom kiri dengan efek abstrak cair/fluid art modern */
        .left-banner {
            background: #020b0d url('https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=800&q=80') center center no-repeat;
            background-size: cover;
            color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 50px;
            position: relative;
            min-height: 550px;
        }

        /* Overlay gelap lembut di atas gambar abstrak agar teks tetap kontras dan terbaca */
        .left-banner::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(135deg, rgba(2, 11, 13, 0.75) 0%, rgba(5, 23, 26, 0.4) 100%);
            z-index: 1;
        }

        .banner-content {
            position: relative;
            z-index: 2;
        }

        /* Kolom kanan tempat meletakkan form pendaftaran */
        .right-form {
            padding: 55px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Styling input minimalis mirip seperti image_1ed3c3.jpg */
        .form-control {
            background-color: #ffffff;
            border: 1px solid #dcdcdc;
            padding: 11px 16px;
            border-radius: 8px;
            font-size: 0.95rem;
            color: #333333;
            transition: all 0.2s ease;
        }

        .form-control::placeholder {
            color: #999999;
        }

        .form-control:focus {
            background-color: #ffffff;
            border-color: #032b30;
            box-shadow: 0 0 0 4px rgba(3, 43, 48, 0.1);
        }

        /* Tombol submit utama berwarna hitam elegan */
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

        /* Tombol Google */
        .btn-outline-custom {
            border: 1px solid #e0e0e0;
            background-color: #ffffff;
            color: #333333;
            padding: 10px;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: background-color 0.2s ease;
        }

        .btn-outline-custom:hover {
            background-color: #f8f9fa;
            border-color: #cccccc;
        }
    </style>
</head>
<body>

    <div class="register-container row g-0">
        
        <div class="col-md-6 left-banner">
            <div class="banner-content">
                <h1 class="fw-bold text-uppercase mb-2" style="letter-spacing: 2px; font-size: 2.8rem; font-family: 'Segoe UI', Arial, sans-serif;">
                    TOKO SYFA
                </h1>
                <p class="text-white-50 lh-base" style="font-size: 1.1rem; font-style: italic; max-width: 340px;">
                    "Macam-macam Produk, Satu Misi: Selamatkan Bumi."
                </p>
            </div>
        </div>

        <div class="col-md-6 right-form">
            <h3 class="fw-bold text-dark mb-4" style="font-size: 1.75rem;">Sign Up</h3>
            
            <form method="POST" action="/register">
                @csrf
                
                <div class="mb-3">
                    <input type="text" name="name" class="form-control" placeholder="Full name" required>
                </div>

                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email address" required>
                </div>

                <div class="mb-3">
                    <input type="tel" name="phone" class="form-control" placeholder="Phone number" required>
                </div>

                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>

                <div class="mb-4">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password" required>
                </div>

                <button type="submit" class="btn btn-submit-custom w-100 d-flex align-items-center justify-content-center gap-2">
                    <span>Join us</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708l3.147-3.146H1.5A.5.5 0 0 1 1 8"/>
                    </svg>
                </button>
            </form>

            <div class="d-flex align-items-center my-4 text-muted">
                <hr class="flex-grow-1 m-0" style="border-color: #eeeeee;">
                <span class="mx-3 small text-lowercase" style="font-size: 0.8rem; color: #aaaaaa;">or</span>
                <hr class="flex-grow-1 m-0" style="border-color: #eeeeee;">
            </div>

            <a href="/auth/google" class="btn btn-outline-custom w-100 d-flex align-items-center justify-content-center gap-2 mb-3 text-decoration-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 48 48">
                    <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                    <path fill="#4285F4" d="M46.5 24c0-1.55-.15-3.24-.47-4.77H24v9.03h12.75c-.55 2.86-2.18 5.29-4.63 6.91l7.19 5.57C43.5 36.33 46.5 30.82 46.5 24z"/>
                    <path fill="#FBBC05" d="M10.54 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.98-6.19z"/>
                    <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.19-5.57c-1.99 1.33-4.55 2.13-8.7 2.13-6.26 0-11.57-4.22-13.46-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                </svg>
                <span>Sign up with Google</span>
            </a>

            <p class="text-center small text-muted mt-3 mb-0">
                Sudah punya akun? <a href="/login" class="text-decoration-none fw-bold text-dark">Masuk di sini</a>
            </p>
        </div>

    </div>

</body>
</html>