@extends('layouts.app')
@section('title', 'Detail - ' . $slugText)

@section('content')
<style>
    .detail-card {
        background: #ffffff; color: #333333; border-radius: 24px; padding: 40px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.3); border: none;
    }
    .product-img-mock {
        background-color: #f0f2f5; min-height: 380px; border-radius: 16px;
        border: 2px dashed #cccccc; display: flex; align-items: center; justify-content: center;
    }
    .variant-selector input[type="radio"] { display: none; }
    .variant-selector label {
        border: 1px solid #dcdcdc; padding: 8px 16px; border-radius: 8px;
        cursor: pointer; font-weight: 500; transition: all 0.2s; margin-right: 8px;
    }
    .variant-selector input[type="radio"]:checked + label {
        background-color: #032b30; color: #ffffff; border-color: #032b30;
    }
    .btn-cart-custom {
        background-color: #111111; color: #ffffff; padding: 14px;
        border-radius: 10px; font-weight: 600; border: none; transition: 0.2s;
    }
    .btn-cart-custom:hover { background-color: #032b30; color: #ffffff; }
    .review-box {
        background-color: #f8f9fa; border-radius: 12px; padding: 15px; margin-bottom: 15px;
    }
</style>

<div class="container-fluid">
    <a href="/" class="btn btn-outline-light mb-4 px-3 py-1.5 small text-white-50">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>

    <div class="card detail-card">
        <div class="row g-5">
            <div class="col-lg-6">
                <div class="product-img-mock flex-column text-secondary">
                    <i class="bi bi-box" style="font-size: 4rem;"></i>
                    <h4 class="fw-bold mt-3 text-uppercase text-muted">{{ $slugText }}</h4>
                    <small class="text-secondary">Simulasi Produk</small>
                </div>
            </div>

            <div class="col-lg-6 d-flex flex-column">
                <span class="badge bg-success align-self-start mb-2 px-3 py-1.5">In Stock</span>
                <h2 class="fw-bold text-dark text-capitalize mb-1">{{ $slugText }}</h2>
                <h3 class="fw-bold text-danger mb-4">{{ $harga }}</h3>

                <h6 class="fw-bold text-secondary mb-2">Deskripsi Produk:</h6>
                <p class="text-muted small mb-4">
                    Produk inovasi ramah lingkungan berkinerja tinggi yang dirancang khusus untuk memenuhi standar efisiensi industri modern. Menggunakan komponen premium teruji tahan lama dan ramah ekosistem lingkungan.
                </p>

                <div class="row mb-4">
                    <div class="col-6">
                        <small class="text-muted d-block">Sisa Stok</small>
                        <strong class="text-dark">{{ $stokProduk }} Unit</strong>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block">Rating</small>
                        <strong class="text-warning"><i class="bi bi-star-fill me-1"></i>5.0</strong>
                    </div>
                </div>

                <form id="addToCartForm" onsubmit="handleAddToCart(event)">
                    <div class="mb-3 variant-selector">
                        <label class="d-block text-secondary small fw-bold mb-2">Pilih Ukuran:</label>
                        <input type="radio" name="size" id="sizeS" value="Reguler (Standard)" checked>
                        <label for="sizeS">Reguler (Standard)</label>
                        
                        <input type="radio" name="size" id="sizeL" value="Pro (Enterprise)">
                        <label for="sizeL">Pro (Enterprise)</label>
                    </div>

                    <div class="mb-4 variant-selector">
                        <label class="d-block text-secondary small fw-bold mb-2">Pilih Warna:</label>
                        <input type="radio" name="color" id="color1" value="Deep Charcoal" checked>
                        <label for="color1">Deep Charcoal</label>
                        
                        <input type="radio" name="color" id="color2" value="Eco Teal">
                        <label for="color2">Eco Teal</label>
                    </div>

                    <div class="mb-4 col-md-4">
                        <label class="form-label text-secondary small fw-bold">Jumlah Kuantitas:</label>
                        <div class="input-group">
                            <button type="button" class="btn btn-outline-secondary" onclick="changeQty(-1)">-</button>
                            <input type="number" id="prodQty" class="form-control text-center fw-bold" value="1" min="1" max="10" readonly style="background:#fff;">
                            <button type="button" class="btn btn-outline-secondary" onclick="changeQty(1)">+</button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-cart-custom w-100 text-uppercase shadow-sm">
                        <i class="bi bi-cart-plus me-2"></i> Tambah ke Keranjang
                    </button>
                </form>
            </div>
        </div>

        <div class="row mt-5 pt-5 border-top">
            <div class="col-12">
                <h4 class="fw-bold text-dark mb-4"><i class="bi bi-chat-left-text-fill me-2 text-secondary"></i>Ulasan Produk</h4>
                
                @if(count($ulasan) > 0)
                    @foreach($ulasan as $u)
                        <div class="review-box shadow-sm">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <strong class="text-dark">{{ $u->nama }}</strong>
                                <span class="text-muted small">{{ $u->created_at->format('H:i') }} WIB</span>
                            </div>
                            <p class="text-secondary small mb-0">"{!! e($u->komentar) !!}"</p>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted small bg-light p-3 rounded-3 text-center">Belum ada ulasan untuk varian ini.</p>
                @endif

                <div class="card bg-light p-4 border-0 rounded-4 mt-4">
                    <h5 class="fw-bold text-dark mb-3">Tinggalkan Feedback Review</h5>
                    <form method="POST" action="/kirim-ulasan/{{ Request::route('slug') }}">
                        @csrf
                        <div class="mb-3">
                            <input type="text" name="nama_reviewer" class="form-control" placeholder="Nama Anda" value="{{ session('user_nama', '') }}" required>
                        </div>
                        <div class="mb-3">
                            <textarea name="isi_ulasan" class="form-control" rows="3" placeholder="Tuliskan komentar ulasan Anda di sini... (Catatan: Konten spam akan diblokir otomatis oleh AWS WAF Web ACL)" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-dark px-4 fw-bold text-uppercase" style="background-color: #032b30; border:none; font-size:0.85rem;">Kirim Ulasan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="cartSuccessModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg text-dark">
            <div class="modal-body text-center p-5">
                <div class="text-success mb-3" style="font-size: 3.5rem;"><i class="bi bi-check-circle-fill"></i></div>
                <h4 class="fw-bold text-dark mb-2">Berhasil Ditambahkan!</h4>
                <p class="text-muted small mb-4" id="cartModalSummary"></p>
                
                <div class="d-grid gap-2">
                    <a href="/dashboard" class="btn btn-dark py-2.5 fw-bold text-uppercase rounded-3 shadow-sm"><i class="bi bi-credit-card me-1"></i> Lihat Keranjang</a>
                    <button type="button" class="btn btn-outline-secondary py-2.5 fw-bold text-uppercase rounded-3" data-bs-dismiss="modal">Lanjut Belanja</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function changeQty(amount) {
        let input = document.getElementById('prodQty');
        let currentVal = parseInt(input.value);
        let newVal = currentVal + amount;
        
        if (newVal >= 1 && newVal <= 10) {
            input.value = newVal;
        }
    }

    function handleAddToCart(event) {
        event.preventDefault();
        
        let qty = parseInt(document.getElementById('prodQty').value);
        let selectedSize = document.querySelector('input[name="size"]:checked').value;
        let selectedColor = document.querySelector('input[name="color"]:checked').value;
        
        let pathArray = window.location.pathname.split('/');
        let currentSlug = pathArray[pathArray.length - 1];

        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                slug: currentSlug,
                quantity: qty,
                size: selectedSize,
                color: selectedColor
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                let badge = document.getElementById('globalCartBadge');
                if (badge) badge.innerText = data.totalItems;
                
                localStorage.setItem('cartItemCount', data.totalItems);

                document.getElementById('cartModalSummary').innerText = `Berhasil menambahkan ${qty} item ke keranjang dengan varian [${selectedSize} - ${selectedColor}].`;
                let myModal = new bootstrap.Modal(document.getElementById('cartSuccessModal'));
                myModal.show();
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>
@endsection