@extends('layouts.app')
@section('title', 'CafeKu - Standar Baru Penikmat Kopi Semarang.')

@section('content')

{{-- Chatbot --}}
@include('partials.chatbot')

{{-- Promo --}}
@include('partials.promo')

<!-- Hero Section -->
<section x-data="{}" class="relative max-w-6xl mx-auto px-6 py-12 md:py-20 overflow-hidden">
    <div class="absolute -top-10 -left-10 w-64 h-64 bg-orange-100/40 rounded-full blur-[80px] -z-10"></div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
        
        <div class="order-2 lg:order-1 space-y-5">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-50 border border-orange-100/50 w-fit">
                <span class="text-[9px] font-black text-orange-600 uppercase tracking-widest">Premium Roasters</span>
            </div>

            <h1 class="text-4xl md:text-5xl font-black text-gray-900 leading-[1.2] tracking-tight">
                Harmoni Rasa <br>
                <span class="text-orange-500 italic font-serif">Racikan Otentik</span> <br>
                di Setiap Cangkir.
            </h1>

            <p class="text-base text-gray-500 max-w-md leading-relaxed font-medium">
                Lebih dari sekadar kopi, kami menghadirkan ruang hangat untuk bercerita dengan biji pilihan yang diproses secara presisi.
            </p>
            
            <div class="flex items-center gap-4 pt-2">
                <a href="#menu"
                @click.prevent="document.querySelector('#menu').scrollIntoView({ behavior: 'smooth' })"
                class="px-8 py-3.5 bg-gray-900 text-white text-sm font-bold rounded-xl hover:bg-orange-600 transition-all shadow-lg shadow-gray-200">
                    Lihat Menu
                </a>
              <button @click="$dispatch('open-chat')" 
        type="button"
        class="flex items-center gap-3 group text-gray-900 transition-all focus:outline-none relative py-2 px-1">
    
    <div class="w-10 h-10 flex items-center justify-center rounded-xl border-2 border-gray-100 
                group-hover:border-orange-500 group-hover:bg-orange-50/50 
                group-active:scale-90 transition-all duration-300">
        
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" 
             stroke="currentColor" class="w-5 h-5 group-hover:text-orange-600 transition-colors">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
        </svg>
    </div>

    <div class="flex flex-col items-start leading-none">
        <span class="text-[10px] font-black uppercase tracking-widest text-gray-400 group-hover:text-orange-500 transition-colors">Assistant</span>
        <span class="text-xs font-black uppercase tracking-tight text-gray-900">Chatbot</span>
    </div>

    <span class="absolute top-2 left-8 w-2.5 h-2.5 bg-green-500 border-2 border-white rounded-full"></span>
</button>
            </div>

            <div class="flex gap-8 pt-6 border-t border-gray-50">
                <div class="flex flex-col">
                    <span class="text-xl font-black text-gray-900">4.9</span>
                    <span class="text-[10px] font-bold text-gray-400 uppercase">Rating</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-xl font-black text-gray-900">15k+</span>
                    <span class="text-[10px] font-bold text-gray-400 uppercase">Cups</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-xl font-black text-gray-900">24/7</span>
                    <span class="text-[10px] font-bold text-gray-400 uppercase">Service</span>
                </div>
            </div>
        </div>

        <div class="order-1 lg:order-2 relative">
            <div class="relative rounded-[2rem] overflow-hidden shadow-xl group">
                <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?q=80&w=2070&auto=format&fit=crop" 
                     alt="Coffee" 
                     loading="lazy"
                     class="w-full h-[450px] object-cover transition-transform duration-700 group-hover:scale-105">
                
                <div class="absolute bottom-4 left-4 bg-white/80 backdrop-blur-md p-4 rounded-2xl border border-white/50 shadow-sm max-w-[200px]">
                    <p class="text-[10px] font-black text-orange-600 uppercase mb-1">Our Favorite</p>
                    <h3 class="text-sm font-bold text-gray-900 leading-tight">Cold Brew Macchiato</h3>
                </div>
            </div>

            <div class="absolute -bottom-4 -right-4 w-32 h-32 bg-orange-100 rounded-[2.5rem] -z-10 animate-pulse"></div>
        </div>
    </div>
</section>
<!-- End of Hero Section -->

<!-- Product Catalog -->
@livewire('product-catalog')
<!-- End of Product Catalog -->

@endsection