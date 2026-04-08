@php
    $cartData = session('cart', []);
    $cartCount = 0;
    if (is_array($cartData)) {
        foreach ($cartData as $item) {
            $cartCount += isset($item['quantity']) ? (int)$item['quantity'] : 0;
        }
    }
@endphp

<nav class="bg-white/90 backdrop-blur-md border-b border-gray-100 sticky top-0 z-50 transition-all duration-300" 
     x-data="{ mobileMenuOpen: false, cartCount: {{ $cartCount }} }" 
     @cart-updated.window="cartCount += $event.detail.change">
    
    <style>
        .fly-item {
            position: fixed;
            z-index: 9999;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-size: cover;
            background-position: center;
            pointer-events: none;
            transition: all 0.8s cubic-bezier(0.42, 0, 0.58, 1);
            border: 2px solid #f97316;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2);
        }
    </style>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            
            <div class="flex items-center gap-4 lg:gap-10">
                <a href="/" class="flex items-center gap-4 lg:gap-6 group shrink-0">
                    <img src="{{ asset('images/gemini-svg.svg') }}" 
                         alt="Logo Cafeku" 
                         class="h-10 w-auto transition-transform duration-300 group-hover:scale-105">

                    <div class="flex items-center gap-1.5">
                        @php
                            $currentHour = now()->format('H');
                            $isOpen = $currentHour >= 7 && $currentHour < 24;
                        @endphp
        
        <span class="relative flex h-2 w-2">
            @if($isOpen)
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
            @endif
            <span class="relative inline-flex rounded-full h-2 w-2 {{ $isOpen ? 'bg-green-500' : 'bg-red-500' }}"></span>
        </span>
        
        <span class="text-[8px] md:text-[9px] font-black uppercase tracking-[0.15em] {{ $isOpen ? 'text-green-600' : 'text-red-500' }}">
            {{ $isOpen ? 'Serving Now' : 'Closed' }}
        </span>
    </div>
</a>

                <div class="hidden lg:flex items-center gap-6">
                    @foreach(['Beranda' => '/', 'Tentang Kami' => '/tentang-kami', 'Katalog Menu' => '/katalog', 'Contact' => '/contact'] as $label => $link)
                    <a href="{{ $link }}" class="text-[10px] font-black uppercase tracking-widest text-gray-500 hover:text-orange-600 transition-all relative group">
                        {{ $label }}
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-orange-500 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    @endforeach
                </div>
            </div>

            <div class="hidden md:flex flex-1 max-w-sm mx-4 lg:mx-8" 
                 x-data="{ 
                    search: '', 
                    results: [], 
                    open: false,
                    fetchProducts() {
                        if(this.search.length < 2) { this.results = []; return; }
                        fetch(`/api/search-products?q=${this.search}`)
                            .then(res => res.json())
                            .then(data => { 
                                this.results = data; 
                                this.open = true; 
                            });
                    },
                    animateToCart(event, imageUrl) {
                        let btn = event.target.getBoundingClientRect();
                        let cart = document.querySelector('#cart-icon-nav').getBoundingClientRect();
                        
                        let flyer = document.createElement('div');
                        flyer.className = 'fly-item';
                        flyer.style.backgroundImage = `url(${imageUrl})`;
                        flyer.style.left = btn.left + 'px';
                        flyer.style.top = btn.top + 'px';
                        document.body.appendChild(flyer);

                        setTimeout(() => {
                            flyer.style.left = cart.left + 'px';
                            flyer.style.top = cart.top + 'px';
                            flyer.style.width = '15px';
                            flyer.style.height = '15px';
                            flyer.style.opacity = '0';
                        }, 100);

                        setTimeout(() => flyer.remove(), 900);
                    }
                 }"
                 x-init="$watch('search', value => fetchProducts())"> 
                
                <div class="relative w-full group">
                    <input type="text" 
                        x-model="search" 
                        @focus="open = true" 
                        @click.away="open = false"
                        placeholder="Cari menu favorit..." 
                        class="block w-full bg-gray-50 border-none rounded-2xl py-2.5 pl-11 pr-4 text-sm font-medium focus:ring-2 focus:ring-orange-500/20 focus:bg-white transition-all outline-none">

                    <div x-show="open && results.length > 0" 
                        x-cloak
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="absolute top-full left-0 w-full mt-3 bg-white rounded-2xl shadow-2xl border border-gray-50 overflow-hidden z-[100]">
                        
                        <div class="max-h-72 overflow-y-auto p-2 space-y-1 scrollbar-hide">
                            <template x-for="item in results" :key="item.id">
                                <button @click="
                                            let imageUrl = item.image_url;
                                            animateToCart($event, imageUrl);
                                            Livewire.dispatch('addToCart', { productId: item.id });
                                            $dispatch('cart-updated', { change: 1 });
                                            search = ''; open = false;
                                        " 
                                        class="w-full text-left p-2.5 hover:bg-orange-50 rounded-xl flex items-center gap-4 transition-all group">
                                    
                                    <img :src="item.image_url" 
                                        class="w-10 h-10 rounded-lg object-cover shadow-sm transition-transform duration-300 group-hover:scale-110"
                                        x-on:error="$el.src='/storage/umkm/americano.jpg'">
                                    
                                    <div class="flex-1">
                                        <p class="text-xs font-black text-gray-900 uppercase leading-none" x-text="item.name"></p>
                                        <p class="text-[10px] text-gray-400 font-bold mt-1" x-text="item.category_name"></p>
                                    </div>
                                    
                                    <span class="text-[9px] font-black text-white bg-orange-500 px-2 py-1 rounded-md opacity-0 translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300 ease-out">
                                        ADD +
                                    </span>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-2 md:gap-3">
                
              <a href="{{ route('order.track.index') }}" 
            class="flex group relative items-center bg-gray-50 hover:bg-orange-50 text-gray-500 hover:text-orange-600 h-11 rounded-2xl px-3 transition-all duration-500 ease-out overflow-hidden max-w-[44px] hover:max-w-[160px]">
                <div class="flex items-center gap-3 whitespace-nowrap">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                    </svg>
                    <span class="text-[10px] font-black uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        Lacak Pesanan
                    </span>
                </div>
            </a>

                <a href="/cart" id="cart-icon-nav" class="group relative flex items-center bg-gray-900 hover:bg-orange-600 text-white h-11 rounded-2xl px-3 transition-all duration-500 ease-out overflow-hidden max-w-[44px] hover:max-w-[160px] shadow-lg shadow-gray-200">
                    <div class="flex items-center gap-3 whitespace-nowrap">
                        <div class="relative flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.112 11.121c.108 1.082-.676 2.072-1.758 2.181A2.25 2.25 0 0 1 18.75 21h-13.5a2.25 2.25 0 0 1-2.25-2.25 2.25 2.25 0 0 1 .059-.512l1.112-11.121c.108-1.082 1.096-1.895 2.181-1.785l11.356 1.112Z" />
                            </svg>
                            <span x-show="cartCount > 0" x-text="cartCount" x-cloak class="absolute -top-1.5 -right-1.5 bg-orange-500 text-[9px] font-black h-4 w-4 flex items-center justify-center rounded-full border-2 border-gray-900 group-hover:border-orange-600 transition-colors">
                                {{ $cartCount }}
                            </span>
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-opacity duration-300">Keranjang</span>
                    </div>
                </a>

                <a href="/admin/login" class="group relative flex items-center bg-gray-50 hover:bg-[#6F4E37] text-gray-500 hover:text-white h-11 rounded-2xl px-3 transition-all duration-500 ease-out overflow-hidden max-w-[44px] hover:max-w-[160px] border border-gray-100">
                    <div class="flex items-center gap-3 whitespace-nowrap">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        <span class="text-[10px] font-black uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-opacity duration-300">Admin Only</span>
                    </div>
                </a>

                <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 text-gray-900">
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" /></svg>
                    <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
        </div>
    </div>

    <div x-show="mobileMenuOpen" x-cloak x-transition class="lg:hidden bg-white border-b border-gray-100 p-6 space-y-4 shadow-xl">
        <a href="/" class="block text-xs font-black uppercase tracking-widest text-gray-500">Beranda</a>
        <a href="/tentang-kami" class="block text-xs font-black uppercase tracking-widest text-gray-500">Tentang Kami</a>
        <a href="/katalog" class="block text-xs font-black uppercase tracking-widest text-gray-500">Katalog Menu</a>
        <a href="/contact" class="block text-xs font-black uppercase tracking-widest text-gray-500">Contact</a>
    </div>
</nav>