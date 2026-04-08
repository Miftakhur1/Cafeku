<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Models\Products;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderTrackingController;

// --- Halaman Utama ---
Route::get('/', [ProductController::class, 'index'])->name('landing');

// --- API Pencarian Produk (Live Search) ---
Route::get('/api/search-products', function (Illuminate\Http\Request $request) {
    $term = $request->query('q');
    
    // Pastikan nama model sesuai (Products atau Product)
    $query = \App\Models\Products::with('categorie');

    if (empty($term)) {
        $products = $query->latest()->limit(10)->get(); 
    } else {
        $products = $query->where('name', 'like', '%' . $term . '%')
                          ->limit(10) 
                          ->get();
    }

    $formattedProducts = $products->map(function ($product) {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'category_name' => $product->categorie->name ?? 'Menu',
            'image_url' => $product->image_url,
        ];
    });

    return response()->json($formattedProducts);
});

// --- Halaman Statis & Katalog ---
Route::get('/tentang-kami', function () {
    return view('about.index');
});

Route::get('/katalog', function () {
    return view('katalog.index');
})->name('katalog');

Route::get('/contact', function () {
    return view('contact.index');
});

// --- Halaman Keranjang Belanja ---
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// --- Alur Checkout & Tracking ---

// 1. Menampilkan halaman input data checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');

// 2. Memproses form checkout (simpan ke database & redirect)
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

// 3. Halaman Instruksi Pembayaran (QRIS / Kasir)
Route::get('/checkout/payment/{order_number}', [CheckoutController::class, 'payment'])->name('checkout.payment');

// 4. FITUR LACAK PESANAN (Tracking)
// Menampilkan halaman form cari (Input Nomor Pesanan)
Route::get('/lacak-pesanan', [OrderTrackingController::class, 'index'])->name('order.track.index');

// Menangani proses pencarian dari form (Redirect ke hasil)
Route::get('/lacak-pesanan/search', [OrderTrackingController::class, 'search'])->name('order.track.search');

// Menampilkan hasil pelacakan detail (Daftar barang & status)
Route::get('/lacak-pesanan/hasil/{order_number}', [OrderTrackingController::class, 'show'])->name('order.track.result');

// 5. Halaman Sukses (Opsional)
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');