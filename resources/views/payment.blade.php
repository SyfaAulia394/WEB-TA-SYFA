@extends('layouts.app')
@section('title', 'Pembayaran')

@section('content')
<div class="container-fluid text-dark d-flex flex-column align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="card p-5 border-0 shadow-lg rounded-4 text-center bg-white" style="max-width: 500px; width: 100%;">
        <div class="text-warning mb-3" style="font-size: 3rem;">
            <i class="bi bi-credit-card-2-back"></i>
        </div>
        <h4 class="fw-bold text-dark mb-2">Simulasi Pembayaran</h4>
        <p class="text-muted small mb-4">Gunakan kode di bawah ini untuk menyelesaikan transaksi.</p>
        
        <div class="text-start bg-light p-4 rounded-3 border mb-4">
            <div class="d-flex justify-content-between mb-2 small">
                <span class="text-secondary">Metode Pembayaran:</span>
                <strong class="text-dark">{{ $trx['metode_bayar'] }}</strong>
            </div>
            <div class="d-flex justify-content-between mb-3 small">
                <span class="text-secondary">Total Tagihan:</span>
                <strong class="text-danger">Rp {{ number_format($trx['total'], 0, ',', '.') }}</strong>
            </div>
            <div class="bg-white p-3 border rounded text-center">
                <small class="text-muted d-block mb-1">Kode Bayar / Virtual Account:</small>
                <h4 class="fw-bold text-dark tracking-wide m-0">8839 0822 1145 6721</h4>
            </div>
        </div>

        <button type="button" class="btn btn-success w-100 fw-bold py-3 text-uppercase rounded-3 shadow" onclick="triggerCallbackSimulation()">
            <i class="bi bi-shield-check-fill me-2"></i>Bayar Sekarang
        </button>
    </div>
</div>

<script>
    function triggerCallbackSimulation() {
        fetch('/payment/callback', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.status === 'success') {
                alert('Pembayaran Berhasil! Mengalihkan ke Halaman Konfirmasi...');
                window.location.href = '/order-confirmation';
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>
@endsection