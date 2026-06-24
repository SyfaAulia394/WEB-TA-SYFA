@extends('layouts.app')
@section('title', 'Keranjang Belanja')

@section('content')
<div class="container-fluid text-dark">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-white"><i class="bi bi-cart-fill me-2 text-warning"></i>Keranjang Belanja</h2>
        <a href="/katalog" class="btn btn-outline-light btn-sm"><i class="bi bi-plus-lg me-1"></i>Tambah Produk</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4" style="background: #ffffff;">
                <h5 class="fw-bold mb-4 border-bottom pb-2">Detail Produk</h5>
                
                @if(isset($cart) && count($cart) > 0)
                    @php $totalBelanja = 0; @endphp
                    @foreach($cart as $key => $item)
                        @php 
                            $subtotal = $item['price'] * $item['quantity']; 
                            $totalBelanja += $subtotal;
                        @endphp
                        <div class="row align-items-center mb-4 pb-3 border-bottom g-3">
                            <div class="col-md-5">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-3 p-3 text-center me-3 text-secondary" style="font-size: 1.5rem; min-width: 65px;">
                                        <i class="bi bi-box-seam"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold text-capitalize text-dark mb-1">{{ $item['name'] }}</h6>
                                        <small class="text-muted d-block">Varian: {{ $item['size'] }}</small>
                                        <small class="text-muted d-block">Warna: {{ $item['color'] }}</small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-2 text-md-center">
                                <small class="text-muted d-block d-md-none">Harga:</small>
                                <span class="fw-semibold">Rp {{ number_format($item['price'], 0, ',', '.') }}</span>
                            </div>

                            <div class="col-md-3">
                                <small class="text-muted d-block d-md-none mb-1">Jumlah:</small>
                                <form action="/cart/update/{{ $key }}" method="POST" class="d-flex align-items-center">
                                    @csrf
                                    <input type="number" name="quantity" class="form-control form-control-sm text-center fw-bold me-2" value="{{ $item['quantity'] }}" min="1" max="10" style="width: 65px;">
                                    <button type="submit" class="btn btn-sm btn-dark px-2" title="Update"><i class="bi bi-arrow-repeat"></i></button>
                                </form>
                            </div>

                            <div class="col-md-2 text-md-end d-flex justify-content-between align-items-center d-md-block">
                                <div class="text-md-end">
                                    <small class="text-muted d-block d-md-none">Subtotal:</small>
                                    <strong class="text-danger">Rp {{ number_format($subtotal, 0, ',', '.') }}</strong>
                                </div>
                                <div class="mt-2">
                                    <a href="/cart/remove/{{ $key }}" class="text-decoration-none btn btn-sm btn-outline-danger border-0 py-0 px-2" title="Hapus">
                                        <i class="bi bi-trash me-1"></i>Hapus
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-5 text-muted">
                        <div class="fs-1 mb-3"><i class="bi bi-cart-x"></i></div>
                        <h5>Keranjang belanja Anda kosong.</h5>
                        <p class="small">Silakan pilih produk terlebih dahulu di katalog.</p>
                        <a href="/katalog" class="btn btn-dark mt-2 px-4 shadow-sm" style="background-color: #032b30; border:none;">Lihat Katalog</a>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 text-white" style="background: #032b30;">
                <h5 class="fw-bold mb-4 border-bottom pb-2">Ringkasan Belanja</h5>
                
                @if(isset($cart) && count($cart) > 0)
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-white-50">Total Produk</span>
                        <span class="fw-bold">{{ array_sum(array_column($cart, 'quantity')) }} Item</span>
                    </div>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="text-white-50">Total Harga</span>
                        <h4 class="fw-bold text-warning">Rp {{ number_format($totalBelanja, 0, ',', '.') }}</h4>
                    </div>
                    
                    <a href="/checkout" class="btn btn-warning w-100 py-3 fw-bold text-uppercase rounded-3 shadow text-center d-block text-decoration-none text-dark">
                        <i class="bi bi-credit-card-2-front me-2"></i>Lanjut ke Checkout
                    </a>
                @else
                    <p class="text-white-50 small text-center my-4">Belum ada produk di keranjang.</p>
                    <button class="btn btn-secondary w-100 py-2 rounded-3 text-uppercase" disabled>Checkout Terkunci</button>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection