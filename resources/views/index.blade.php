@extends('layouts.app')
@section('title', 'Beranda')

@section('content')
<style>
    .hero-banner {
        background: linear-gradient(135deg, #111111 0%, #032b30 100%);
        border-radius: 20px; padding: 40px;
        border: 1px solid rgba(255, 255, 255, 0.05);
        box-shadow: 0 15px 35px rgba(0,0,0,0.4);
    }
    .search-box {
        background: #ffffff; border-radius: 12px; padding: 6px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }
    .form-control-search { border: none; padding-left: 15px; color: #333; }
    .form-control-search:focus { box-shadow: none; }
    
    .category-btn {
        background-color: rgba(255, 255, 255, 0.08); color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 8px 22px; border-radius: 30px; font-weight: 500;
        transition: all 0.2s ease;
    }
    .category-btn:hover, .category-btn.active {
        background-color: #ffcc00; color: #111111; border-color: #ffcc00;
    }
    .product-card-item {
        background: #ffffff; border: none; border-radius: 16px;
        color: #333333; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        overflow: hidden; transition: transform 0.2s ease;
    }
    .product-card-item:hover { transform: translateY(-5px); }
    
    .product-featured {
        border: 2px solid #ffcc00 !important;
        background: linear-gradient(to bottom, #ffffff 80%, #fffdf0 100%) !important;
    }
    
    .btn-buy-now {
        background-color: #111111; color: #ffffff; border: none;
        font-weight: 600; transition: 0.2s;
    }
    .btn-buy-now:hover { background-color: #032b30; color: #ffffff; }
    .badge-tag { background-color: #032b30; color: #fff; }
    .product-img-wrapper {
        height: 180px;
        overflow: hidden;
        border-radius: 12px;
        background-color: #f8f9fa;
    }
    .product-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>

<div class="container-fluid">
    <div class="hero-banner mb-5">
        <span class="badge bg-warning text-dark mb-2 fw-bold px-3 py-1.5">PROMO</span>
        <h2 class="fw-bold text-white mb-1">Toko Syfa Console</h2>
        <p class="text-white-50 small mb-0">Belanja produk ramah lingkungan dan teknologi terpercaya.</p>
    </div>

    <div class="row justify-content-center mb-5">
        <div class="col-md-9">
            <div class="search-box d-flex align-items-center mb-4">
                <i class="bi bi-search text-muted ms-3"></i>
                <input type="text" id="searchInput" class="form-control form-control-search flex-grow-1" placeholder="Cari produk terpercaya di Toko Syfa...">
                <button onclick="filterProducts()" class="btn btn-dark px-4 py-2 rounded-3 fw-bold" style="background-color: #032b30; border: none;">Cari</button>
            </div>
            
            <div class="d-flex justify-content-center gap-2 flex-wrap">
                <button onclick="selectCategory('Semua', this)" class="btn category-btn active">Semua</button>
                <button onclick="selectCategory('Hardware', this)" class="btn category-btn">Hardware</button>
                <button onclick="selectCategory('Manufaktur', this)" class="btn category-btn">Manufaktur</button>
                <button onclick="selectCategory('Eco-Friendly', this)" class="btn category-btn">Eco-Friendly</button>
            </div>
        </div>
    </div>

    <h4 class="fw-bold text-warning mb-4 border-bottom pb-2 d-inline-block">
        <i class="bi bi-fire me-2"></i>Produk Pilihan
    </h4>
    
    <div class="row g-4" id="productGrid">
        @php
            // KUNCI PERBAIKAN: Hanya menyisakan 11 produk yang gambarnya valid
            $products = [
                ['name' => 'Laptop Pro X1', 'cat' => 'Hardware', 'img' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=500&auto=format&fit=crop&q=60', 'price' => 1250000, 'featured' => true],
                ['name' => 'Eco Canvas Bag', 'cat' => 'Eco-Friendly', 'img' => 'https://images.unsplash.com/photo-1544816155-12df9643f363?w=500&auto=format&fit=crop&q=60', 'price' => 3750000, 'featured' => false],
                ['name' => 'Server Tower S1', 'cat' => 'Hardware', 'img' => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=500&auto=format&fit=crop&q=60', 'price' => 5000000, 'featured' => true],
                ['name' => 'Bamboo Keyboard', 'cat' => 'Eco-Friendly', 'img' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=500&auto=format&fit=crop&q=60', 'price' => 7500000, 'featured' => false],
                ['name' => 'Pneumatic Act', 'cat' => 'Manufaktur', 'img' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?w=500&auto=format&fit=crop&q=60', 'price' => 10000000, 'featured' => false],
                ['name' => 'Solar Panel Mini', 'cat' => 'Eco-Friendly', 'img' => 'https://images.unsplash.com/photo-1509391366360-2e959784a276?w=500&auto=format&fit=crop&q=60', 'price' => 11250000, 'featured' => false],
                ['name' => 'SSD NVMe Tech', 'cat' => 'Hardware', 'img' => 'https://images.unsplash.com/photo-1591488320449-011701bb6704?w=500&auto=format&fit=crop&q=60', 'price' => 12500000, 'featured' => false],
                ['name' => 'Stepper Motor', 'cat' => 'Manufaktur', 'img' => 'https://images.unsplash.com/photo-1620283085439-39620a1e21c4?w=500&auto=format&fit=crop&q=60', 'price' => 13750000, 'featured' => false],
                ['name' => 'Recycled Box X', 'cat' => 'Eco-Friendly', 'img' => 'https://images.unsplash.com/photo-1530587191325-3db32d826c18?w=500&auto=format&fit=crop&q=60', 'price' => 15000000, 'featured' => false],
                ['name' => 'PLC Controller', 'cat' => 'Manufaktur', 'img' => 'https://images.unsplash.com/photo-1555664424-778a1e5e1b48?w=500&auto=format&fit=crop&q=60', 'price' => 17500000, 'featured' => false],
                ['name' => 'Bio Bottle Pack', 'cat' => 'Eco-Friendly', 'img' => 'https://images.unsplash.com/photo-1602143407151-7111542de6e8?w=500&auto=format&fit=crop&q=60', 'price' => 18750000, 'featured' => false],
            ];
        @endphp

        @foreach($products as $prod)
            @php
                $slug = Str::slug($prod['name']);
                $hargaFormatted = 'Rp ' . number_format($prod['price'], 0, ',', '.');
            @endphp
            
            <div class="col-md-6 col-lg-4 product-card-container" data-category="{{ $prod['cat'] }}" data-name="{{ strtolower($prod['name']) }}">
                <div class="card product-card-item h-100 p-3 {{ $prod['featured'] ? 'product-featured' : '' }}">
                    
                    <div class="product-img-wrapper mb-3">
                        <img src="{{ $prod['img'] }}" alt="{{ $prod['name'] }}">
                    </div>

                    <div class="card-body p-0 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge badge-tag">{{ $prod['cat'] }}</span>
                            @if($prod['featured'])
                                <span class="badge bg-warning text-dark fw-bold"><i class="bi bi-star-fill me-1"></i>Top Seller</span>
                            @endif
                        </div>
                        
                        <h5 class="fw-bold text-dark mb-1 text-capitalize">{{ $prod['name'] }}</h5>
                        <h6 class="fw-bold text-danger mb-3">{{ $hargaFormatted }}</h6>
                        <a href="/produk/{{ $slug }}" class="btn btn-buy-now w-100 py-2 mt-auto text-decoration-none text-center">
                            Detail Produk
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
    let currentCategory = 'Semua';

    function selectCategory(category, button) {
        document.querySelectorAll('.category-btn').forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');
        
        currentCategory = category;
        filterProducts();
    }

    function filterProducts() {
        let keyword = document.getElementById('searchInput').value.toLowerCase();
        let items = document.querySelectorAll('.product-card-container');

        items.forEach(item => {
            let itemCategory = item.getAttribute('data-category');
            let itemName = item.getAttribute('data-name');

            let matchCategory = (currentCategory === 'Semua' || itemCategory === currentCategory);
            let matchKeyword = itemName.includes(keyword);

            if (matchCategory && matchKeyword) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    document.getElementById('searchInput').addEventListener('keyup', function(e) {
        if (e.key === 'Enter') {
            filterProducts();
        }
    });
</script>
@endsection