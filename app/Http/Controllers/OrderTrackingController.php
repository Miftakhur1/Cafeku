<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    /**
     * Menampilkan halaman form pencarian (Input Nomor Pesanan)
     */
    public function index()
    {
        return view('order.track-input');
    }

    /**
     * Memproses pencarian dan menampilkan hasil pelacakan
     */
    public function search(Request $request)
    {
        // 1. Validasi input agar tidak kosong
        $request->validate([
            'order_number' => 'required|string',
        ], [
            'order_number.required' => 'Silakan masukkan nomor pesanan Anda.',
        ]);

        $orderNumber = $request->input('order_number');

        // 2. Ambil data Order beserta relasi items dan product-nya (Eager Loading)
        // Ini supaya kita bisa panggil nama produk di halaman hasil tanpa error
        $order = Order::with(['items.product'])
            ->where('order_number', $orderNumber)
            ->first();

        // 3. Jika data tidak ada di database
        if (!$order) {
            return back()->with('error', 'Nomor pesanan "' . $orderNumber . '" tidak ditemukan. Periksa kembali penulisan Anda.');
        }

        // 4. Jika data ditemukan, arahkan ke view hasil dengan membawa data $order
        return view('order.track-result', compact('order'));
    }
}