<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function update(Request $request, $id)
    {
        $cart = session()->get('cart');
        if (!is_array($cart)) {
            $cart = [];
            session()->put('cart', $cart);
        }
        if(isset($cart[$id])) {
            $cart[$id]['quantity'] = max(1, (int)$request->quantity);
            session()->put('cart', $cart);
        }
        return redirect()->back(); // Ini akan merefresh halaman ke posisi semula
    }

    public function remove($id)
    {
        $cart = session()->get('cart');
        if (!is_array($cart)) {
            $cart = [];
            session()->put('cart', $cart);
        }
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back();
    }
}