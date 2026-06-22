@extends('layouts.app')
@section('title', 'Riwayat Pesanan Saya')

@section('content')
<div class="container-fluid text-dark">
    <!-- Header -->
    <div class="mb-4 d-flex justify-content-between align-items-center flex-wrap g-3">
        <div>
            <h2 class="fw-bold text-white"><i class="bi bi-box-seam me-2"></i>Pesanan Saya</h2>
            <p class="text-white-50 small mb-0">Pantau status pengiriman dan riwayat belanja Anda.</p>
        </div>
        @if(count($orders) > 0 && $orders[0]['status_tracking'] !== 'Diterima')
            <a href="/simulasi-kirim-barang" class="btn btn-warning fw-bold btn-sm shadow-sm">
                <i class="bi bi-gear me-1"></i> Status Kurir
            </a>
        @endif
    </div>

    <!-- Alert Notifikasi -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                
                @if(count($orders) > 0)
                    @foreach($orders as $order)
                        <div class="border rounded-4 p-4 mb-3">
                            <!-- Informasi Invoice -->
                            <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4 flex-wrap g-2">
                                <div>
                                    <span class="text-muted small">No. Invoice</span>
                                    <h6 class="fw-bold m-0 text-dark">{{ $order['nomor_invoice'] }}</h6>
                                </div>
                                <div>
                                    <span class="text-muted small d-block text-md-end">Metode Pembayaran</span>
                                    <span class="badge bg-secondary">{{ $order['metode_bayar'] }}</span>
                                </div>
                            </div>

                            <!-- Progress Tracker -->
                            <h6 class="fw-bold mb-3 text-secondary"><i class="bi bi-geo-alt me-1"></i>Status Pengiriman:</h6>
                            <div class="row text-center position-relative mb-5 g-0">
                                <div class="col-4">
                                    <div class="fw-bold mb-1 {{ in_array($order['status_tracking'], ['Diproses', 'Dikirim', 'Diterima']) ? 'text-primary' : 'text-muted' }}">
                                        <i class="bi bi-clock me-1"></i> Diproses
                                    </div>
                                    <small class="text-muted d-none d-md-block">Pesanan sedang disiapkan</small>
                                </div>
                                <div class="col-4">
                                    <div class="fw-bold mb-1 {{ in_array($order['status_tracking'], ['Dikirim', 'Diterima']) ? 'text-primary' : 'text-muted' }}">
                                        <i class="bi bi-truck me-1"></i> Dikirim
                                    </div>
                                    <small class="text-muted d-none d-md-block">Pesanan dalam perjalanan</small>
                                </div>
                                <div class="col-4">
                                    <div class="fw-bold mb-1 {{ $order['status_tracking'] == 'Diterima' ? 'text-success' : 'text-muted' }}">
                                        <i class="bi bi-check-circle me-1"></i> Diterima
                                    </div>
                                    <small class="text-muted d-none d-md-block">Pesanan telah sampai</small>
                                </div>
                            </div>

                            <!-- Bagian Ulasan -->
                            @if($order['status_tracking'] === 'Diterima')
                                <div class="bg-light p-4 rounded-4 border border-success mt-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="text-success fs-3 me-3"><i class="bi bi-star-fill"></i></div>
                                        <div>
                                            <h6 class="fw-bold text-success mb-0">Pesanan Selesai! Berikan Ulasan</h6>
                                            <p class="text-muted small mb-0">Bantu kami meningkatkan kualitas layanan dengan ulasan Anda.</p>
                                        </div>
                                    </div>
                                    
                                    <form action="/kirim-ulasan/laptop-pro-x1" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label small fw-bold">Nama Lengkap:</label>
                                            <input type="text" name="nama_reviewer" class="form-control form-control-sm" placeholder="Nama Anda" value="{{ session('user_nama', '') }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label small fw-bold">Ulasan Produk:</label>
                                            <textarea name="isi_ulasan" class="form-control form-control-sm" rows="3" placeholder="Tulis komentar ulasan Anda mengenai produk ini..." required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-success btn-sm px-4 fw-bold shadow-sm">
                                            Kirim Ulasan
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="alert alert-info border-0 rounded-3 mb-0 small">
                                    <i class="bi bi-info-circle me-1"></i> Tombol <strong>Tulis Ulasan</strong> akan terbuka otomatis setelah status pesanan berubah menjadi <strong>[Diterima]</strong>.
                                </div>
                            @endif

                        </div>
                    @endforeach
                @else
                    <!-- Tampilan Jika Riwayat Kosong -->
                    <div class="text-center py-5">
                        <div class="text-muted" style="font-size: 3.5rem;"><i class="bi bi-box-seam"></i></div>
                        <h5 class="mt-3 text-muted">Belum ada transaksi.</h5>
                        <p class="text-secondary small">Semua riwayat belanja Anda akan muncul di halaman ini.</p>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection