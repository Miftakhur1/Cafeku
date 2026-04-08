<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Import model kamu di sini
use App\Models\Products; 
use App\Models\Categories;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil data kategori
        $categories = Categories::all();
        
        // Mengambil data produk
        $products = Products::with('categorie')->get();

        // Mengirim ke view welcome.blade.php
        return view('welcome', compact('categories', 'products'));
    }
}