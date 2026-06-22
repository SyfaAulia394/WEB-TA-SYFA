@extends('layouts.app')
@section('title', 'Katalog Produk')

@section('content')
<style>
    .page-title {
        color: #ffcc00;
        letter-spacing: 1px;
    }
    .product-card-item {
        background: #ffffff;
        border: none;
        border-radius: 16px;
        color: #333333;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        transition: transform 0.2s ease;
    }
    .product-card-item:hover {
        transform: translateY(-5px);
    }
    
    .product-featured {
        border: 2px solid #ffcc00 !important;
        background: linear-gradient(to bottom, #ffffff 80%, #fffdf0 100%) !important;
    }
    
    .btn-buy-now {
        background-color: #111111;
        color: #ffffff;
        border: none;
        font-weight: 600;
        transition: 0.2s;
    }
    .btn-buy-now:hover {
        background-color: #032b30;
        color: #ffffff;
    }
    .badge-tag {
        background-color: #032b30;
        color: #fff;
    }
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
    <div class="mb-4">
        <h2 class="fw-bold page-title"><i class="bi bi-bag-fill me-2"></i>Katalog Produk</h2>
        <p class="text-white-50 small">Temukan berbagai produk teknologi dan pilihan terbaik untuk Anda.</p>
    </div>

    <div class="row g-4">
        @php
            // KUNCI PERBAIKAN: Hanya menyisakan 11 produk yang gambarnya valid di katalog
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
            
            <div class="col-md-6 col-lg-4">
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
@endsection