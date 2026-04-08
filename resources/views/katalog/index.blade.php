@extends('layouts.app')
@section('title', 'CafeKu - Katalog Menu')
<link rel="icon" type="image/svg+xml" href="{{ asset('images/gemini-svg.svg') }}">

@include('partials.chatbot')

@section('content')

<div class="overflow-x-hidden bg-[#FDFDFD]">

    <section class="relative pt-24 pb-16 md:pt-32 md:pb-24 px-4 sm:px-6 overflow-hidden">
        
        <div class="absolute inset-0 bg-gradient-to-br from-orange-50/50 via-transparent to-orange-100/20 -z-10"></div>
        <div class="absolute -top-24 -left-24 w-72 h-72 bg-orange-200/10 rounded-full blur-[80px] -z-10"></div>

        <div class="max-w-6xl mx-auto grid lg:grid-cols-12 gap-8 items-center">
            
            <div class="lg:col-span-7 space-y-6 md:space-y-8 fade-soft">
                
                <div class="space-y-3 md:space-y-4">
                    <div class="inline-flex items-center gap-2">
                        <span class="w-6 h-[1px] bg-orange-500"></span>
                        <h2 class="text-orange-600 font-black tracking-[0.2em] text-[9px] md:text-[10px] uppercase">
                            Est. MMXXIII — Semarang
                        </h2>
                    </div>

                    <h1 class="text-4xl sm:text-5xl md:text-6xl font-black leading-[1] tracking-tighter text-neutral-900 uppercase italic">
                        Katalog <br>
                        <span class="not-italic text-black">Eksklusif</span> <br>
                        <span class="text-orange-500">Signature.</span>
                    </h1>
                </div>

                <div class="bg-white p-5 md:p-6 rounded-[1.5rem] border border-neutral-100 
                            shadow-sm hover:shadow-xl hover:shadow-orange-100/30 transition-all duration-500 max-w-lg group">

                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="space-y-2">
                            <div class="flex items-center gap-2 text-orange-600">
                                <span class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-70"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-orange-600"></span>
                                </span>
                                <h4 class="font-black text-[9px] uppercase tracking-widest">
                                    Booking Your Table
                                </h4>
                            </div>
                            <p class="text-neutral-500 text-xs leading-relaxed max-w-[250px]">
                                Amankan tempat favorit Anda untuk pengalaman kopi yang lebih intim.
                            </p>
                        </div>

                        <a href="https://wa.me/6281234567890" target="_blank"
                           class="inline-flex items-center justify-center px-6 py-3 
                                  bg-neutral-950 text-white rounded-xl text-[9px] font-black uppercase tracking-widest
                                  transition-all duration-500 hover:bg-orange-600 hover:-translate-y-0.5 
                                  active:scale-95 shadow-md">
                            Reservasi
                        </a>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5 relative fade-soft hidden md:block">
                <div class="relative z-10 rounded-[2rem] overflow-hidden shadow-xl group aspect-[1/1] max-w-[400px] ml-auto">
                    {{-- Mengarah ke public/storage/images/latte.webp --}}
                    <img src="{{ asset('storage/umkm/latte.webp') }}" 
                        alt="Signature Latte" 
                        class="w-full h-full object-cover  grayscale group-hover:grayscale-0 group-hover:scale-105 transition-all duration-700">
                    
                </div>
                
                <div class="absolute -bottom-4 -left-4 bg-white p-4 shadow-xl rounded-2xl border border-neutral-50 animate-float hidden lg:block z-20"> 
                    <p class="text-[8px] text-orange-500 font-black uppercase tracking-widest mb-1">Barista Pick</p>
                    <h3 class="text-base font-black tracking-tighter italic">Signature Latte<span class="text-orange-500">.</span></h3>
                </div>
            </div>

        </div>
    </section>

    <section id="menu" class="py-12 px-4 sm:px-6 bg-white border-t border-neutral-50 rounded-t-[2.5rem] -mt-6 relative z-30 shadow-[0_-15px_50px_-20px_rgba(0,0,0,0.05)]">
    <div class="max-w-6xl mx-auto">
        
        <div class="relative py-12 mb-8 fade-up">
    <div class="absolute top-0 left-0 w-full h-full flex items-center justify-center opacity-[0.03] pointer-events-none">
        <span class="text-[15vw] font-black uppercase tracking-tighter">DISCOVER</span>
    </div>

    <div class="relative z-10 text-center space-y-4">
        <div class="flex items-center justify-center gap-4 mb-2">
            <span class="h-[1px] w-12 bg-neutral-200"></span>
            <span class="text-orange-500 text-[9px] uppercase font-black tracking-[0.5em]">The Craft</span>
            <span class="h-[1px] w-12 bg-neutral-200"></span>
        </div>
        
        <h3 class="text-4xl md:text-6xl font-black tracking-tighter uppercase italic leading-none">
            DAFTAR <span class="text-orange-600 not-italic">ARTISAN.</span>
        </h3>
        
        <p class="text-neutral-400 text-[10px] md:text-xs uppercase tracking-[0.2em] font-medium max-w-xs mx-auto">
            Seleksi rasa yang dikurasi dengan presisi tinggi.
        </p>
    </div>
</div>

        <div class="min-h-[300px] fade-up" id="livewire-container" style="transition-delay: 400ms">
            @livewire('product-catalog')
        </div>

    </div>
</section>

</div>

<style>
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    .animate-float { animation: float 4s ease-in-out infinite; }

    .fade-soft {
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    .fade-soft.is-visible {
        opacity: 1;
        transform: translateY(0);
    }
</style>

<script>
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if(entry.isIntersecting){
                entry.target.classList.add('is-visible');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.fade-soft').forEach(el => observer.observe(el));
</script>

@endsection