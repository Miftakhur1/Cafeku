<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (!is_array($cart)) {
            $cart = [];
            session()->put('cart', $cart);
        }
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjangmu masih kosong!');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            if (is_array($item) && isset($item['price'], $item['quantity'])) {
                $subtotal += $item['price'] * $item['quantity'];
            }
        }

        return view('checkout.index', [
            'cart' => $cart,
            'subtotal' => $subtotal,
            'tax' => $subtotal * 0.1 
        ]);
    }

    public function process(Request $request)
    {
        $cart = session()->get('cart', []);
        if (!is_array($cart)) {
            $cart = [];
            session()->put('cart', $cart);
        }
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong!');
        }

        // 1. VALIDASI DATA (PENTING: Menghindari error "Column cannot be null")
        $request->validate([
            'customer_name'  => 'required|string|min:2|max:255',
            'service_type'   => 'required|in:dine-in,delivery',
            'payment_method' => 'required',
            'phone'          => 'required_if:service_type,delivery|nullable|numeric',
            'address'        => 'required_if:service_type,delivery|nullable|string',
    ]);

        // Gunakan Database Transaction agar jika simpan detail gagal, order utama juga dibatalkan
        return DB::transaction(function () use ($request, $cart) {
            
            // 2. Hitung Total
            $subtotal = 0;
            foreach ($cart as $item) {
                if (is_array($item) && isset($item['price'], $item['quantity'])) {
                    $subtotal += $item['price'] * $item['quantity'];
                }
            }
            
            $tax = $subtotal * 0.1;
            
            // Logika Ongkir yang lebih bersih
            $shipping = 0;
            if ($request->service_type === 'delivery') {
                $address = strtolower($request->address ?? '');
                $shipping = str_contains($address, 'semarang') ? 0 : 15000;
            }
            
            $totalPrice = $subtotal + $tax + $shipping;
            $orderNumber = 'ORD-' . strtoupper(Str::random(6));

            // 3. SIMPAN KE DATABASE (Tabel Orders)
            $order = Order::create([
                'order_number'   => $orderNumber,
                'customer_name'  => $request->customer_name,
                'service_type'   => $request->service_type,
                'payment_method' => $request->payment_method,
                'address'        => $request->address,
                'table_number'   => $request->table_number,
                'phone'          => $request->phone,
                'total_price'    => $totalPrice,
                'status'         => 'pending',
            ]);

            // 4. SIMPAN DETAIL KE DATABASE (Tabel OrderItems)
            foreach ($cart as $productId => $item) {
                if (is_array($item) && isset($item['quantity'], $item['price'])) {
                    OrderItem::create([
                        'order_id'   => $order->id,
                        'product_id' => $productId,
                        'quantity'   => $item['quantity'],
                        'unit_price' => $item['price'],
                        'subtotal'   => $item['price'] * $item['quantity'],
                    ]);
                }
            }

            // Hapus keranjang
            session()->forget('cart');

            // Redirect ke halaman pembayaran
            return redirect()->route('checkout.payment', $order->order_number);
        });
}


   public function payment($order_number)
{
    // Ambil dari database, bukan session
    $order = Order::where('order_number', $order_number)->first();

    if (!$order) {
        return redirect()->route('landing')->with('error', 'Pesanan tidak ditemukan.');
    }

    return view('checkout.payment', compact('order'));
}

public function track($order_number)
{
    // Ambil dari database beserta item produknya (Eager Loading)
    $order = Order::with('items.product')
                  ->where('order_number', $order_number)
                  ->first();

    if (!$order) {
        return redirect()->route('landing')->with('error', 'Pesanan tidak ditemukan.');
    }

    return view('order.track', compact('order'));
}
}