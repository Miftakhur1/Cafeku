@extends('layouts.app')
<title>CafeKu - Keranjang</title>
@section('content')
<div class="bg-[#f8f9fa] min-h-screen pb-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-8 md:py-12">
        
        {{-- Header Area --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8 border-b border-gray-200 pb-8">
            <div>
                <h1 class="text-3xl font-black text-gray-900 tracking-tight uppercase">Keranjang</h1>
                <p class="text-sm text-gray-500 mt-1 font-medium">
                    Konfirmasi pesanan <span class="text-orange-600 font-bold">{{ count(session('cart', [])) }} menu</span> sebelum checkout.
                </p>
            </div>

            <div class="flex flex-col md:items-end gap-4">
                {{-- Progress Belanja --}}
                <div class="flex items-center gap-3 bg-white px-4 py-2 rounded-2xl border border-gray-100 shadow-sm">
                    <div class="flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-gray-900 text-white text-[9px] font-black flex items-center justify-center">1</span>
                        <span class="text-[9px] font-black uppercase tracking-widest text-gray-900">Cart</span>
                    </div>
                    <div class="w-6 h-[1px] bg-gray-200"></div>
                    <div class="flex items-center gap-2 opacity-30">
                        <span class="w-6 h-6 rounded-full bg-gray-200 text-gray-500 text-[9px] font-black flex items-center justify-center">2</span>
                        <span class="text-[9px] font-black uppercase tracking-widest text-gray-400">Info</span>
                    </div>
                    <div class="w-6 h-[1px] bg-gray-200"></div>
                    <div class="flex items-center gap-2 opacity-30">
                        <span class="w-6 h-6 rounded-full bg-gray-200 text-gray-500 text-[9px] font-black flex items-center justify-center">3</span>
                        <span class="text-[9px] font-black uppercase tracking-widest text-gray-400">Bayar</span>
                    </div>
                </div>

                <a href="/katalog" class="text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-orange-600 transition-colors flex items-center gap-2 group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali Eksplor Menu
                </a>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            
            {{-- Item List Area --}}
            <div class="flex-grow space-y-4">
                @php 
                    $cart = session('cart', []);
                    if (!is_array($cart)) {
                        $cart = [];
                        session(['cart' => $cart]);
                    }
                    $subtotal = 0;
                @endphp

                @forelse($cart as $id => $details)
                    @if(is_array($details) && isset($details['price'], $details['quantity']))
                    @php 
                        $itemTotal = $details['price'] * $details['quantity'];
                        $subtotal += $itemTotal;

                        $cartImage = asset('storage/umkm/americano.jpg');
                        if (!empty($details['image'])) {
                            $imagePath = ltrim($details['image'], '/');
                            $imageCandidates = [
                                $imagePath,
                                'umkm/' . $imagePath,
                                'products/' . $imagePath,
                                'umkm/products/' . $imagePath,
                            ];

                            foreach ($imageCandidates as $candidate) {
                                if (file_exists(storage_path('app/public/' . $candidate))) {
                                    $cartImage = asset('storage/' . $candidate);
                                    break;
                                }
                            }
                        }
                    @endphp
                    
                    <div class="bg-white rounded-2xl border border-gray-100 p-4 hover:shadow-md transition-shadow duration-300">
                        <div class="flex items-center gap-5">
                            
                            {{-- Image Section --}}
                            <div class="w-20 h-20 md:w-24 md:h-24 rounded-xl overflow-hidden bg-gray-50 shrink-0 border border-gray-100">
                                <img src="{{ $cartImage }}" 
                                     class="w-full h-full object-cover"
                                     onerror="this.onerror=null;this.src='{{ asset('storage/umkm/americano.jpg') }}';">
                            </div>

                            {{-- Content Grid --}}
                            <div class="flex-grow grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                                <div class="md:col-span-5">
                                    <span class="text-[9px] font-bold uppercase tracking-widest text-orange-500 block mb-1 italic">
                                        Selected Menu
                                    </span>
                                    <h3 class="text-base font-bold text-gray-900 leading-tight uppercase">{{ $details['name'] }}</h3>
                                    <p class="text-[10px] text-gray-400 mt-1 font-bold">HARGA: Rp {{ number_format($details['price'], 0, ',', '.') }}</p>
                                </div>

                                {{-- Quantity Control --}}
                                <div class="md:col-span-3 flex justify-start md:justify-center">
                                    <div class="flex items-center bg-gray-50 rounded-lg p-1 border border-gray-100">
                                        <form action="{{ route('cart.update', $id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="quantity" value="{{ $details['quantity'] - 1 }}">
                                            <button type="submit" {{ $details['quantity'] <= 1 ? 'disabled' : '' }} class="w-7 h-7 flex items-center justify-center rounded-md bg-white shadow-sm text-gray-500 hover:text-orange-600 disabled:opacity-30">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" /></svg>
                                            </button>
                                        </form>
                                        <span class="w-8 text-center text-xs font-bold text-gray-900">{{ $details['quantity'] }}</span>
                                        <form action="{{ route('cart.update', $id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="quantity" value="{{ $details['quantity'] + 1 }}">
                                            <button type="submit" class="w-7 h-7 flex items-center justify-center rounded-md bg-white shadow-sm text-gray-500 hover:text-orange-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                {{-- Price & Delete --}}
                                <div class="md:col-span-4 flex items-center justify-between md:justify-end gap-6">
                                    <div class="text-right">
                                        <p class="text-[9px] text-gray-400 font-black uppercase tracking-tighter">Subtotal</p>
                                        <p class="text-sm font-black text-gray-900">Rp {{ number_format($itemTotal, 0, ',', '.') }}</p>
                                    </div>
                                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-gray-300 hover:text-red-500 transition-colors p-1 active:scale-90">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                @empty
                    <div class="bg-white rounded-[2rem] border border-dashed border-gray-200 py-20 px-6 text-center">
                        <div class="text-4xl mb-4 opacity-20">🛒</div>
                        <p class="text-xs text-gray-400 font-black uppercase tracking-widest">Keranjang masih kosong</p>
                    </div>
                @endforelse
            </div>

            {{-- Summary Sidebar --}}
            <aside class="w-full lg:w-[380px]">
                <div class="bg-white rounded-[2rem] border border-gray-100 p-8 shadow-sm sticky top-8">
                    <h2 class="text-sm font-black text-gray-900 uppercase tracking-[0.2em] mb-6 pb-4 border-b border-gray-50">Ringkasan</h2>
                    
                    <div class="space-y-4 mb-8">
                        <div class="flex justify-between text-xs font-bold">
                            <span class="text-gray-400 uppercase tracking-widest">Subtotal</span>
                            <span class="text-gray-900">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-xs font-bold">
                            <span class="text-gray-400 uppercase tracking-widest">PPN (10%)</span>
                            <span class="text-gray-900">Rp {{ number_format($subtotal * 0.1, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between pt-5 border-t border-gray-50 items-center">
                            <span class="text-[10px] font-black text-gray-900 uppercase tracking-[0.2em]">Total</span>
                            <span class="font-black text-orange-600 text-xl tracking-tighter">Rp {{ number_format($subtotal * 1.1, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <a href="{{ count($cart) > 0 ? '/checkout' : '#' }}" 
                        class="w-full py-5 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] transition-all flex justify-center items-center 
                        {{ count($cart) > 0 
                            ? 'bg-gray-900 hover:bg-orange-600 text-white shadow-xl active:scale-95' 
                            : 'bg-gray-100 text-gray-300 cursor-not-allowed pointer-events-none' }}">
                        Checkout Sekarang
                    </a>
                </div>
            </aside>
        </div>
    </div>
</div>
@endsection