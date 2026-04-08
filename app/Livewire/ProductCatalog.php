<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Products;
use App\Models\Categories;

class ProductCatalog extends Component
{
    public $selectedCategory = null;
    public $search = '';

    // Listener untuk menangkap perintah "Add" dari Search di Navbar
    protected $listeners = ['addToCart' => 'addToCart'];

    public function selectCategory($slug = null)
    {
        $this->selectedCategory = $slug;
    }

    public function addToCart($productId)
    {
        $product = Products::find($productId);
        
        if (!$product) return; // Keamanan jika produk tidak ada

        $cart = session()->get('cart', []);
        if (!is_array($cart)) {
            $cart = [];
        }

        if(isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);

        // Jika Navbar bukan Livewire, kita trigger event browser agar AlpineJS di Navbar bisa baca
        $this->dispatch('refresh-navbar'); 

        // Notifikasi ke user
        $this->dispatch('alert', [
            'type' => 'success',
            'message' => $product->name . ' masuk ke keranjang!'
        ]);
    }

    public function render()
    {
        $categories = Categories::all();

        $products = Products::with('categorie')
            ->when($this->selectedCategory, function($query) {
                return $query->whereHas('categorie', function($q) {
                    $q->where('slug', $this->selectedCategory);
                });
            })
            ->when($this->search, function($query) {
                return $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->get();

        return view('livewire.product-catalog', [
            'products' => $products,
            'categories' => $categories
        ]);
    }
}