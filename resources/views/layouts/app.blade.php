<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Toko Syfa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        body { 
            background: radial-gradient(circle at 10% 20%, #032b30 0%, #05171a 40%, #020b0d 100%); 
            color: #ffffff; 
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
        }
        /* Layout Grid Utama untuk Sidebar */
        .main-wrapper {
            display: flex;
        }
        .sidebar {
            width: 260px;
            background-color: rgba(17, 17, 17, 0.95);
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            min-height: 100vh;
            position: fixed;
            top: 0; left: 0;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            z-index: 1000;
        }
        .content-area {
            margin-left: 260px;
            flex-grow: 1;
            padding: 40px;
        }
        .sidebar-brand {
            font-weight: 700;
            color: #ffcc00 !important;
            letter-spacing: 1.5px;
            font-size: 1.4rem;
            text-decoration: none;
            margin-bottom: 40px;
            display: block;
        }
        .nav-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            flex-grow: 1;
        }
        .nav-menu-item {
            margin-bottom: 10px;
        }
        .nav-menu-link {
            display: flex;
            align-items: center;
            padding: 12px 18px;
            color: #aaaaaa;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        .nav-menu-link i {
            font-size: 1.15rem;
            margin-right: 12px;
        }
        .nav-menu-link:hover, .nav-menu-link.active {
            background-color: rgba(3, 43, 48, 0.4);
            color: #ffcc00;
        }
        .sidebar-footer {
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            padding-top: 15px;
        }
    </style>
</head>
<body>

    <div class="main-wrapper">
        <div class="sidebar">
            <a class="sidebar-brand text-center text-uppercase" href="/"><i class="bi bi-shield-lock-fill me-2"></i>TOKO SYFA</a>
            
            <small class="text-white-50 text-uppercase fw-bold mb-2 d-block" style="font-size: 0.7rem; letter-spacing: 0.5px;">Menu Utama</small>
            <ul class="nav-menu">
                <li class="nav-menu-item">
                    <a class="nav-menu-link {{ Request::is('/') ? 'active' : '' }}" href="/">
                        <i class="bi bi-house-door"></i>
                        <span>Beranda</span>
                    </a>
                </li>
                <li class="nav-menu-item">
                    <a class="nav-menu-link {{ Request::is('katalog') || Request::is('produk*') ? 'active' : '' }}" href="/katalog">
                        <i class="bi bi-grid"></i>
                        <span>Katalog</span>
                    </a>
                </li>
                <li class="nav-menu-item">
                    <a class="nav-menu-link d-flex justify-content-between align-items-center {{ Request::is('dashboard') ? 'active' : '' }}" href="/dashboard">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-cart3"></i>
                            <span>Keranjang</span>
                        </div>
                        <span id="globalCartBadge" class="badge bg-warning text-dark fw-bold rounded-pill">0</span>
                    </a>
                </li>
            </ul>

            <div class="sidebar-footer">
                <small class="text-white-50 text-uppercase fw-bold mb-2 d-block" style="font-size: 0.7rem; letter-spacing: 0.5px;">Autentikasi</small>
                <ul class="nav-menu">
                    <li class="nav-menu-item">
                        <a class="nav-menu-link {{ Request::is('register') ? 'active' : '' }}" href="/register">
                            <i class="bi bi-person-plus"></i>
                            <span>Register</span>
                        </a>
                    </li>
                    <li class="nav-menu-item">
                        <a class="nav-menu-link {{ Request::is('login') ? 'active' : '' }}" href="/login">
                            <i class="bi bi-box-arrow-in-right"></i>
                            <span>Sign In</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="content-area">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let totalCartCount = parseInt(localStorage.getItem('cartItemCount')) || 0;
            let badge = document.getElementById('globalCartBadge');
            if (badge) {
                badge.innerText = totalCartCount;
            }
        });
    </script>
</body>
</html>