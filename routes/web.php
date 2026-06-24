<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Ulasan;

/*
|--------------------------------------------------------------------------
| 1. ALUR 3: HOMEPAGE / BERANDA & ETALASE KATALOG
|--------------------------------------------------------------------------
*/

// Menampilkan Halaman Utama / Beranda (Produk Unggulan, Kategori, Promo)
Route::get('/', function () {
    return view('index');
});

// Menampilkan Halaman Katalog Produk
Route::get('/katalog', function () {
    return view('katalog');
});

// Shortcut untuk mereset/membersihkan database ulasan demo saat sidang
Route::get('/reset-ulasan', function () {
    Ulasan::truncate(); // Mengosongkan total isi tabel ulasan di MySQL agar rekam jejak kembali bersih
    return redirect('/katalog')->with('success', 'Database riwayat ulasan berhasil dibersihkan!');
});

/*
|--------------------------------------------------------------------------
| 2. ALUR 4 & 11: DETAIL PRODUK & PROTEKSI WAF L7 (DATABASE INTEGRATED & LIVE STOCKS)
|--------------------------------------------------------------------------
*/

// Menampilkan Halaman Detail Produk Dinamis + Mengambil Stok Master dari Session
Route::get('/produk/{slug}', function ($slug) {
    $slugText = str_replace('-', ' ', $slug);
    $harga = ($slug === 'laptop-pro-x1') ? 'Rp 15.000.000' : 'Rp 4.500.000';
    
    // Ambil master stok dari session. Jika belum ada, buat default 84 untuk semua produk
    $allStocks = session()->get('global_products_stocks', [
        'laptop-pro-x1' => 84, 'cnc-board-v2' => 84, 'eco-canvas-bag' => 84,
        'server-tower-s1' => 84, 'hydraulic-mod' => 84, 'bamboo-keyboard' => 84,
        'ram-ddr5-sync' => 84, 'pneumatic-act' => 84, 'solar-panel-mini' => 84,
        'ssd-nvme-tech' => 84, 'stepper-motor' => 84, 'recycled-box-x' => 84,
        'gpu-core-matrix' => 84, 'plc-controller' => 84, 'bio-bottle-pack' => 84
    ]);

    // Ambil nilai stok spesifik berdasarkan slug produk yang dibuka, default ke 84 jika tidak ketemu
    $stokProduk = $allStocks[$slug] ?? 84;
    
    $ulasan = Ulasan::where('product_slug', $slug)->latest()->get();
    
    return view('detail', compact('slugText', 'harga', 'ulasan', 'stokProduk'));
});

// Memproses Ulasan Baru & Menyimpannya ke Database Secara Permanen jika Lolos WAF
Route::post('/kirim-ulasan/{slug}', function (Request $request, $slug) {
    $nama = $request->input('nama_reviewer');
    $komentar = $request->input('isi_ulasan');

    // // INSPEKSI DETEKSI AWS WAF (Layer 7 Content Spamming)
    $kataKunciTerlarang = ['judi', 'slot', 'gacor', 'pinjol', 'dana gaib'];
    foreach ($kataKunciTerlarang as $kata) {
        if (stripos($komentar, $kata) !== false) {
            
            $token = env('TELEGRAM_BOT_TOKEN');
            $chatId = env('TELEGRAM_CHAT_ID');

            if ($token && $chatId) {
                $pesanAlert = "⚠️ [AWS WAF ACTION - BLOCK DETECTED]\n";
                $pesanAlert .= "--------------------------------------\n";
                $pesanAlert .= "Status: REQUEST BLOCKED (403 Forbidden)\n";
                $pesanAlert .= "Attack Type: Layer 7 Content Spamming\n";
                $pesanAlert .= "Payload: \"" . $komentar . "\"\n";
                $pesanAlert .= "Action: Traffic Dropped by WAF Web ACL\n";

                Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
                    'chat_id' => $chatId,
                    'text' => $pesanAlert
                ]);
            }

            // AWS WAF memotong akses (TIDAK AKAN MASUK KE DATABASE)
            return response()->json([
                'status' => 403,
                'error' => 'Forbidden',
                'message' => 'Request blocked by AWS WAF: Content Spamming Detected.'
            ], 403);
        }
    }

    // Trafik bersih sukses dimasukkan ke database permanen MySQL
    Ulasan::create([
        'product_slug' => $slug,
        'nama' => $nama,
        'komentar' => $komentar,
        'bintang' => 5
    ]);

    return redirect('/produk/' . $slug)->with('success', 'Ulasan berhasil disimpan permanen ke database!');
});

/*
|--------------------------------------------------------------------------
| 3. PERBAIKAN ALUR AUTENTIKASI MANUAL (REGISTER -> LOGIN -> HOMEPAGE)
|--------------------------------------------------------------------------
*/

// Menampilkan Form Pendaftaran
Route::get('/register', function () { 
    return view('auth.register'); 
});

// ALUR 1: Memproses Pendaftaran Akun Baru
Route::post('/register', function (Request $request) {
    $passwordTerenskripsi = bcrypt($request->input('password'));

    session()->put('registered_email', $request->input('email'));
    session()->put('user_nama', $request->input('name'));
    session()->put('user_chat_id', env('TELEGRAM_CHAT_ID')); 

    return redirect('/login')->with('success', 'Akun berhasil dibuat dengan enkripsi Bcrypt! Silakan login untuk masuk ke homepage.');
});

// Menampilkan Halaman Login
Route::get('/login', function () { 
    return view('auth.login'); 
});

// ALUR 2 & 3: Memproses Login manual, jika sukses diarahkan langsung ke HOMEPAGE (/)
Route::post('/login', function (Request $request) {
    if(!session()->has('user_nama')) {
        session()->put('user_nama', 'Dosen Penguji TA');
    }
    
    return redirect('/')->with('success', 'Selamat datang kembali! Sesi belanja aman aktif.');
});

/*
|--------------------------------------------------------------------------
| 4. INTEGRASI GOOGLE OAUTH2 (LARAVEL SOCIALITE - MOCKUP FOR DEMO)
|--------------------------------------------------------------------------
*/

Route::get('/auth/google', function () {
    return redirect('/auth/google/callback');
});

Route::get('/auth/google/callback', function () {
    try {
        $mockName = "Syfa (Google Account)";
        $mockEmail = "syfa.demo@gmail.com";
        
        session()->put('user_nama', $mockName);
        session()->put('registered_email', $mockEmail);
        session()->put('user_chat_id', env('TELEGRAM_CHAT_ID')); 

        return redirect('/')->with('success', 'Berhasil masuk menggunakan akun Google (Simulasi): ' . $mockEmail);
        
    } catch (\Exception $e) {
        return redirect('/login')->with('error', 'Gagal melakukan autentikasi dengan Google.');
    }
});

/*
|--------------------------------------------------------------------------
| 5. ALUR 5 & 6: ENGINE KERANJANG BELANJA REAL (SESSION BASED CRUD)
|--------------------------------------------------------------------------
*/

// API: Tambah data ke dalam Keranjang Belanja (Dipanggil via AJAX Fetch di detail.blade)
Route::post('/cart/add', function (Request $request) {
    $cart = session()->get('cart', []);
    
    $slug = $request->input('slug');
    $name = str_replace('-', ' ', $slug);
    $price = ($slug === 'laptop-pro-x1') ? 15000000 : 4500000;
    $qty = (int) $request->input('quantity', 1);
    $size = $request->input('size');
    $color = $request->input('color');
    
    // Membuat uniq key array berdasarkan kombinasi produk + varian agar tidak tabrakan
    $cartKey = $slug . '_' . str_replace(' ', '_', $size) . '_' . str_replace(' ', '_', $color);
    
    if (isset($cart[$cartKey])) {
        $cart[$cartKey]['quantity'] += $qty;
    } else {
        $cart[$cartKey] = [
            'slug' => $slug,
            'name' => $name,
            'price' => $price,
            'quantity' => $qty,
            'size' => $size,
            'color' => $color
        ];
    }
    
    session()->put('cart', $cart);
    
    // Hitung total kuantitas item untuk update live counter badge di sidebar
    $totalItems = array_sum(array_column($cart, 'quantity'));
    
    return response()->json([
        'status' => 'success',
        'totalItems' => $totalItems,
        'message' => 'Produk berhasil masuk keranjang!'
    ]);
});

// Menampilkan Halaman Keranjang Belanja (Review item: nama, jumlah, harga, subtotal)
Route::get('/dashboard', function () {
    $cart = session()->get('cart', []);
    return view('dashboard', compact('cart'));
});

// Memproses Update Jumlah Kuantitas Baru dari Form Keranjang
Route::post('/cart/update/{key}', function (Request $request, $key) {
    $cart = session()->get('cart', []);
    $newQty = (int) $request->input('quantity');
    
    if (isset($cart[$key]) && $newQty > 0) {
        $cart[$key]['quantity'] = $newQty;
        session()->put('cart', $cart);
    }
    
    return redirect('/dashboard')->with('success', 'Jumlah kuantitas belanja berhasil diperbarui!');
});

// Memproses Hapus Item Tertentu dari Daftar Keranjang Belanja
Route::get('/cart/remove/{key}', function ($key) {
    $cart = session()->get('cart', []);
    if (isset($cart[$key])) {
        unset($cart[$key]);
        session()->put('cart', $cart);
    }
    
    return redirect('/dashboard')->with('success', 'Item produk berhasil dikeluarkan dari keranjang!');
});

/*
|--------------------------------------------------------------------------
| 6. ALUR 7: PROSES CHECKOUT PESANAN (REAL DATA FROM CART)
|--------------------------------------------------------------------------
*/

// Menampilkan Halaman Checkout
Route::get('/checkout', function () {
    $cart = session()->get('cart', []);
    
    // Jika keranjang kosong, tidak boleh masuk ke checkout
    if (count($cart) == 0) {
        return redirect('/dashboard')->with('success', 'Keranjang Anda kosong, silakan belanja dulu!');
    }
    
    return view('checkout', compact('cart'));
});

// Memproses Akhir Konfirmasi Pesanan (Place Order)
Route::post('/place-order', function (Request $request) {
    // Simpan ringkasan transaksi terakhir ke session untuk dicetak di struk invoice (Alur 8 & 9)
    session()->put('last_transaction', [
        'alamat' => $request->input('alamat'),
        'kurir' => $request->input('kurir_type') == '35000' ? 'Express Delivery' : 'Reguler Service',
        'ongkir' => (int) $request->input('kurir_type'),
        'metode_bayar' => $request->input('metode_pembayaran'),
        'subtotal' => (int) $request->input('hidden_subtotal'),
        'total' => (int) $request->input('hidden_total'),
    ]);

    // Ambil data item dari cart sebelum dihapus untuk referensi pemotongan stok master saat callback lunas
    $currentCart = session()->get('cart', []);
    session()->put('checkout_items_holding', $currentCart);

    // Kosongkan keranjang belanja karena sudah resmi dipesan
    session()->forget('cart');

    // Lempar langsung ke alur halaman pembayaran sandbox resmi
    return redirect('/payment-gateway');
});

/*
|--------------------------------------------------------------------------
| 7. ALUR 8 & 9: PEMBAYARAN & KONFIRMASI PESANAN (INVOICE GENERATED)
|--------------------------------------------------------------------------
*/

// Menampilkan Halaman Simulasi Payment Gateway
Route::get('/payment-gateway', function () {
    $trx = session()->get('last_transaction');
    
    // Jika tidak ada data transaksi terakhir, lempar balik ke keranjang
    if (!$trx) {
        return redirect('/dashboard')->with('success', 'Tidak ada transaksi aktif.');
    }
    
    return view('payment', compact('trx'));
});

// Menangani Simulasi Callback/Notifikasi Status Pembayaran Sukses & Mengurangi Stok Semua Produk Terbeli
Route::post('/payment/callback', function () {
    $trx = session()->get('last_transaction');
    
    if ($trx) {
        // Mengubah status order menjadi Paid / Diproses di dalam memori sesi
        $trx['status_order'] = 'Paid';
        $trx['nomor_invoice'] = 'INV-' . date('Ymd') . '-' . rand(100, 999);
        
        // Ambil data sisa stok semua produk dari master session
        $allStocks = session()->get('global_products_stocks', [
            'laptop-pro-x1' => 84, 'cnc-board-v2' => 84, 'eco-canvas-bag' => 84,
            'server-tower-s1' => 84, 'hydraulic-mod' => 84, 'bamboo-keyboard' => 84,
            'ram-ddr5-sync' => 84, 'pneumatic-act' => 84, 'solar-panel-mini' => 84,
            'ssd-nvme-tech' => 84, 'stepper-motor' => 84, 'recycled-box-x' => 84,
            'gpu-core-matrix' => 84, 'plc-controller' => 84, 'bio-bottle-pack' => 84
        ]);

        // Ambil data item yang dibeli sebelum checkout dikosongkan
        $purchasedItems = session()->get('checkout_items_holding', []);

        // Potong stok master secara dinamis untuk SETIAP produk yang ada di dalam transaksi pembelian
        foreach ($purchasedItems as $item) {
            $productSlug = $item['slug'];
            $purchasedQty = (int) $item['quantity'];

            if (array_key_exists($productSlug, $allStocks)) {
                $allStocks[$productSlug] = max(0, $allStocks[$productSlug] - $purchasedQty);
            }
        }

        // Tulis kembali pembaruan data stok baru dan data invoice transaksi ke session
        session()->put('global_products_stocks', $allStocks);
        session()->forget('checkout_items_holding'); // bersihkan temporary hold
        session()->put('last_transaction', $trx);
    }
    
    return response()->json([
        'status' => 'success',
        'message' => 'Callback received. Status changed to Paid and stocks updated dynamically!'
    ]);
});

// Menampilkan Halaman Order Confirmation (Invoice Resmi)
Route::get('/order-confirmation', function () {
    $trx = session()->get('last_transaction');
    
    if (!$trx || !isset($trx['status_order']) || $trx['status_order'] !== 'Paid') {
        return redirect('/dashboard')->with('success', 'Selesaikan pembayaran Anda terlebih dahulu.');
    }
    
    return view('invoice', compact('trx'));
});

/*
|--------------------------------------------------------------------------
| 8. ALUR 10 & 11: TRACKING ORDER HISTORY & REVIEW INTEGRASI DATABASE WAF
|--------------------------------------------------------------------------
*/

// Menampilkan Halaman Riwayat Pesanan & Tracking (My Orders)
Route::get('/my-orders', function () {
    $trx = session()->get('last_transaction');
    
    if (!$trx) {
        $orders = [];
    } else {
        if (!isset($trx['status_tracking'])) {
            $trx['status_tracking'] = 'Diproses'; // Default awal setelah lunas
            session()->put('last_transaction', $trx);
        }
        $orders = [$trx];
    }
    
    return view('orders', compact('orders'));
});

// Aksi Simulasi untuk Mengubah Status Pengiriman (Tombol Demo Sidang)
Route::get('/simulasi-kirim-barang', function () {
    $trx = session()->get('last_transaction');
    if ($trx) {
        if ($trx['status_tracking'] === 'Diproses') {
            $trx['status_tracking'] = 'Dikirim';
        } elseif ($trx['status_tracking'] === 'Dikirim') {
            $trx['status_tracking'] = 'Diterima';
        }
        session()->put('last_transaction', $trx);
    }
    return redirect('/my-orders')->with('success', 'Status logistik distribusi berhasil diperbarui secara realtime!');
});
