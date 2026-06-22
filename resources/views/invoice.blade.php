@extends('layouts.app')
@section('title', 'Konfirmasi Pesanan')

@section('content')
<div class="container-fluid text-dark">
    <div class="card p-5 border-0 shadow-sm rounded-4 mx-auto bg-white" style="max-width: 650px;">
        <div class="text-center mb-4">
            <div class="text-success mb-2" style="font-size: 4rem;">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <h3 class="fw-bold text-success mb-1">Pesanan Diterima</h3>
            <p class="text-muted small">Detail rincian belanja telah dikirimkan ke email Anda.</p>
            <span class="badge bg-success text-uppercase px-3 py-2 mt-1">Status: {{ $trx['status_order'] }}</span>
        </div>

        <div class="border-top border-bottom py-4 mb-4">
            <h6 class="fw-bold mb-3 text-secondary">
                <i class="bi bi-receipt me-2"></i>No. Invoice: {{ $trx['nomor_invoice'] }}
            </h6>
            <div class="row g-3 small">
                <div class="col-5 text-muted">Alamat Pengiriman:</div>
                <div class="col-7 fw-semibold text-dark text-end">{{ $trx['alamat'] }}</div>

                <div class="col-5 text-muted">Metode Pengiriman:</div>
                <div class="col-7 fw-semibold text-dark text-end">{{ $trx['kurir'] }}</div>

                <div class="col-5 text-muted">Metode Pembayaran:</div>
                <div class="col-7 fw-semibold text-dark text-end">{{ $trx['metode_bayar'] }}</div>
            </div>
        </div>

        <h6 class="fw-bold mb-3 text-dark">
            <i class="bi bi-card-list me-2 text-secondary"></i>Ringkasan Pembayaran
        </h6>
        <div class="bg-light p-3 rounded-3 mb-4 small">
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Subtotal</span>
                <span class="fw-semibold">Rp {{ number_format($trx['subtotal'], 0, ',', '.') }}</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Ongkos Kirim</span>
                <span class="fw-semibold">Rp {{ number_format($trx['ongkir'], 0, ',', '.') }}</span>
            </div>
            <hr>
            <div class="d-flex justify-content-between align-items-center fw-bold text-dark fs-5">
                <span>Total Bayar:</span>
                <span class="text-danger">Rp {{ number_format($trx['total'], 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="d-grid">
            <a href="/my-orders" class="btn btn-dark py-3 fw-bold text-uppercase rounded-3 shadow-sm text-center d-block text-decoration-none text-white" style="background-color: #032b30; border:none;">
                <i class="bi bi-truck me-2"></i> Lacak Pesanan
            </a>
        </div>
    </div>
</div>
@endsection