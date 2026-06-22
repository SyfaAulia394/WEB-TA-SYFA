@extends('layouts.app')
@section('title', 'Checkout')

@section('content')
<div class="container-fluid text-dark">
    <div class="mb-4">
        <h2 class="fw-bold text-white">Checkout Pesanan</h2>
        <p class="text-white-50 small">Lengkapi data pengiriman dan pilih metode pembayaran Anda.</p>
    </div>

    <form action="/place-order" method="POST" onsubmit="clearLocalCartCounter()">
        @csrf
        <div class="row g-4">
            
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4" style="background: #ffffff;">
                    <h5 class="fw-bold mb-3 text-dark border-bottom pb-2">
                        <i class="bi bi-truck me-2 text-secondary"></i>Pengiriman
                    </h5>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Alamat Lengkap:</label>
                        <textarea name="alamat" class="form-control" rows="3" placeholder="Contoh: Jl. Kampus Politeknik Negeri Padang, Limau Manis, Kec. Pauh, Kota Padang" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Metode Pengiriman:</label>
                        <select name="kurir_type" id="checkoutKurir" class="form-select" onchange="hitungCheckout()" required>
                            <option value="15000" selected>Reguler (3-5 Hari) - Rp 15.000</option>
                            <option value="35000">Express (1-2 Hari) - Rp 35.000</option>
                        </select>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 p-4" style="background: #ffffff;">
                    <h5 class="fw-bold mb-3 text-dark border-bottom pb-2">
                        <i class="bi bi-credit-card me-2 text-secondary"></i>Metode Pembayaran
                    </h5>
                    <div class="mb-2">
                        <select name="metode_pembayaran" class="form-select" required>
                            <option value="Transfer Bank (Virtual Account)">Transfer Bank (Virtual Account)</option>
                            <option value="E-Wallet (OVO/Dana/QRIS)">E-Wallet (OVO / Dana / QRIS)</option>
                            <option value="Kartu Kredit / Debit">Kartu Kredit / Debit</option>
                            <option value="COD (Bayar di Tempat)">COD (Bayar di Tempat)</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 p-4 text-white" style="background: #032b30;">
                    <h5 class="fw-bold mb-3 border-bottom pb-2 text-warning">
                        <i class="bi bi-list-check me-2"></i>Ringkasan Pesanan
                    </h5>
                    
                    @php $subtotalCheckout = 0; @endphp
                    <div class="mb-3" style="max-height: 180px; overflow-y: auto;">
                        @foreach($cart as $item)
                            @php $subtotalCheckout += ($item['price'] * $item['quantity']); @endphp
                            <div class="d-flex justify-content-between align-items-center small mb-2 bg-black bg-opacity-25 p-2 rounded">
                                <div>
                                    <span class="text-capitalize fw-bold d-block">{{ $item['name'] }}</span>
                                    <small class="text-white-50">{{ $item['quantity'] }}x | Varian: {{ $item['size'] }}</small>
                                </div>
                                <span class="fw-bold text-warning">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-between small mb-2">
                        <span class="text-white-50">Subtotal Produk</span>
                        <span class="fw-bold" id="txtSubtotal">Rp {{ number_format($subtotalCheckout, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between small mb-2">
                        <span class="text-white-50">Ongkos Kirim</span>
                        <span class="fw-bold" id="txtOngkir">Rp 15.000</span>
                    </div>
                    <div class="d-flex justify-content-between small mb-3">
                        <span class="text-white-50">Diskon</span>
                        <span class="text-success fw-bold">- Rp 0</span>
                    </div>

                    <hr class="border-secondary">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="fw-bold">Total Tagihan:</span>
                        <h4 class="fw-bold text-warning m-0" id="txtTotal">Rp {{ number_format($subtotalCheckout + 15000, 0, ',', '.') }}</h4>
                    </div>

                    <input type="hidden" name="hidden_subtotal" id="hideSubtotal" value="{{ $subtotalCheckout }}">
                    <input type="hidden" name="hidden_total" id="hideTotal" value="{{ $subtotalCheckout + 15000 }}">

                    <button type="submit" class="btn btn-warning w-100 py-3 fw-bold text-uppercase rounded-3 shadow text-dark mb-2">
                        Konfirmasi Pesanan
                    </button>
                    <a href="/dashboard" class="btn btn-outline-light w-100 py-2 small text-center rounded-3">
                        Kembali ke Keranjang
                    </a>
                </div>
            </div>

        </div>
    </form>
</div>

<script>
    function hitungCheckout() {
        let subtotal = parseInt(document.getElementById('hideSubtotal').value);
        let ongkir = parseInt(document.getElementById('checkoutKurir').value);
        let total = subtotal + ongkir;

        document.getElementById('txtOngkir').innerText = 'Rp ' + ongkir.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        document.getElementById('txtTotal').innerText = 'Rp ' + total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        
        document.getElementById('hideTotal').value = total;
    }

    function clearLocalCartCounter() {
        localStorage.setItem('cartItemCount', 0);
    }
</script>
@endsection