<div>
    <header id="menu" class="max-w-7xl mx-auto px-6 pt-12 pb-6">
        <div class="flex items-end justify-between mb-6">
            <div>
                <h2 class="text-2xl font-black text-gray-900 tracking-tight">Katalog <span class="text-orange-500 italic font-serif">Menu.</span></h2>
                <p class="text-xs text-gray-400 mt-1 uppercase font-bold tracking-widest">Pilihan terbaik untuk menemani harimu</p>
            </div>
            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest bg-gray-50 px-3 py-1 rounded-full border border-gray-100">
                {{ $products->count() }} Produk
            </span>
        </div>

        {{-- Filter Kategori --}}
        <div class="flex gap-3 overflow-x-auto pb-2 no-scrollbar">
            <button wire:click="selectCategory(null)" 
                class="px-5 py-2.5 rounded-full text-xs font-black uppercase tracking-widest transition-all shrink-0
                {{ !$selectedCategory ? 'bg-gray-900 text-white shadow-lg' : 'bg-white border border-gray-200 text-gray-500 hover:bg-gray-50' }}">
                Semua
            </button>

            @foreach($categories as $cat)
                <button wire:click="selectCategory('{{ $cat->slug }}')" 
                    class="px-5 py-2.5 rounded-full text-xs font-black uppercase tracking-widest transition-all shrink-0
                    {{ $selectedCategory == $cat->slug ? 'bg-gray-900 text-white shadow-lg' : 'bg-white border border-gray-200 text-gray-500 hover:text-orange-600 hover:border-orange-400' }}">
                    {{ $cat->name }}
                </button>
            @endforeach
        </div>
    </header>

    <main wire:loading.class="opacity-40 pointer-events-none" 
          class="max-w-7xl mx-auto px-6 pb-24 transition-all duration-300">

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">

            @forelse($products as $product)
                @php
                    $productImage = $product->image_url;
                @endphp

                <div wire:key="prod-{{ $product->id }}"
                     class="group relative rounded-[2rem] overflow-hidden bg-white border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-500 flex flex-col h-full">

                    {{-- Image Section --}}
                    <div class="relative aspect-square overflow-hidden bg-gray-50">
                        <img src="{{ $productImage }}" 
                             id="prod-img-{{ $product->id }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition duration-700"
                             {{-- Jika file fisik tidak ada di folder, lari ke Americano --}}
                             onerror="this.onerror=null;this.src='{{ asset('storage/umkm/americano.jpg') }}';">

                        <div class="absolute top-3 left-3">
                            <span class="px-3 py-1 bg-white/90 backdrop-blur-md rounded-full text-[9px] font-black uppercase tracking-widest text-gray-700 shadow-sm border border-white/50">
                                {{ $product->categorie->name ?? 'Menu' }}
                            </span>
                        </div>
                    </div>

                    {{-- Content Section --}}
                    <div class="p-4 flex flex-col flex-1 justify-between gap-3">
                        <div>
                            <h3 class="text-[11px] font-black text-gray-900 uppercase leading-tight line-clamp-2 group-hover:text-orange-600 transition">
                                {{ $product->name }}
                            </h3>
                            <p class="text-[9px] text-gray-400 font-bold uppercase tracking-tighter mt-1 italic">
                                Quality Ingredients
                            </p>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-base font-black text-gray-900">
                                    <span class="text-[10px] text-orange-500 font-bold">Rp</span>{{ number_format($product->price, 0, ',', '.') }}
                                </p>
                            </div>

                            <button 
                                @click="
                                    let btn = $event.currentTarget.getBoundingClientRect();
                                    let cart = document.querySelector('#cart-icon-nav').getBoundingClientRect();
                                    let img = '{{ $productImage }}';
                                    
                                    let flyer = document.createElement('div');
                                    flyer.className = 'fly-item';
                                    flyer.style.backgroundImage = `url(${img})`;
                                    flyer.style.left = btn.left + 'px';
                                    flyer.style.top = btn.top + 'px';
                                    document.body.appendChild(flyer);

                                    setTimeout(() => {
                                        flyer.style.left = cart.left + 'px';
                                        flyer.style.top = cart.top + 'px';
                                        flyer.style.width = '20px';
                                        flyer.style.height = '20px';
                                        flyer.style.opacity = '0';
                                    }, 100);

                                    setTimeout(() => flyer.remove(), 900);
                                    
                                    $wire.addToCart({{ $product->id }});
                                    window.dispatchEvent(new CustomEvent('cart-updated', { detail: { change: 1 } }));
                                "
                                wire:loading.attr="disabled"
                                class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-900 text-white hover:bg-orange-600 transition-all shadow-lg active:scale-90 group/btn">
                                
                                <span wire:loading.remove wire:target="addToCart({{ $product->id }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                </span>

                                <span wire:loading wire:target="addToCart({{ $product->id }})">
                                    <svg class="animate-spin h-4 w-4 text-white" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>

            @empty
                <div class="col-span-full flex flex-col items-center justify-center py-24 bg-gray-50 rounded-[3rem] border-2 border-dashed border-gray-100">
                    <div class="text-3xl mb-3 opacity-20">☕</div>
                    <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Menu tidak ditemukan</h3>
                </div>
            @endforelse
        </div>
    </main>

    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        .fly-item {
            position: fixed;
            z-index: 9999;
            width: 50px;
            height: 50px;
            border-radius: 15px;
            background-size: cover;
            background-position: center;
            pointer-events: none;
            transition: all 0.7s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 2px solid #fff;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
    </style>
</div>