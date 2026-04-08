@extends('layouts.app')

@section('title', 'CafeKu - Contact & Reservation')
<link rel="icon" type="image/svg+xml" href="{{ asset('images/gemini-svg.svg') }}">

@include('partials.chatbot')

@section('content')

<section class="relative min-h-[80vh] flex items-center justify-center py-12 px-4 overflow-hidden bg-[#FDFDFD]">
    {{-- Animated Background Orbs --}}
    <div class="absolute top-0 left-0 w-full h-full -z-10 overflow-hidden">
        <div class="absolute top-1/4 -left-20 w-80 h-80 bg-orange-100/40 blur-[100px] rounded-full animate-drift"></div>
        <div class="absolute bottom-1/4 -right-20 w-80 h-80 bg-orange-200/30 blur-[100px] rounded-full animate-drift-slow"></div>
    </div>

    <div class="max-w-4xl mx-auto w-full">
        <div class="text-center space-y-8">
            
            {{-- Header Section --}}
            <div class="space-y-4 fade-up">
                <div class="inline-flex items-center gap-3 overflow-hidden">
                    <span class="w-6 h-[1px] bg-orange-500 origin-left animate-grow-line"></span>
                    <span class="text-[9px] tracking-[0.4em] uppercase text-orange-600 font-black">
                        Direct Connection
                    </span>
                    <span class="w-6 h-[1px] bg-orange-500 origin-right animate-grow-line"></span>
                </div>

                <h1 class="text-4xl md:text-6xl font-black text-neutral-900 leading-tight tracking-tighter uppercase italic stagger-item">
                    RESERVASI <br>
                    <span class="text-orange-500 not-italic inline-block hover:scale-105 transition-transform duration-500 cursor-default">WHATSAPP.</span>
                </h1>

                <p class="text-neutral-500 text-xs md:text-sm max-w-md mx-auto leading-relaxed font-medium stagger-item">
                    Lupakan formulir yang membosankan. Klik tombol di bawah untuk terhubung langsung. Reservasi tempat jadi lebih personal dan cepat.
                </p>
            </div>

            {{-- Info Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 stagger-container">
                @php
                    $infos = [
                        ['icon' => '📍', 'label' => 'Lokasi', 'val' => 'Semarang', 'sub' => 'Near USM'],
                        ['icon' => '🕒', 'label' => 'Operasional', 'val' => '07.00 - 24.00', 'sub' => 'Setiap Hari'],
                        ['icon' => '☕', 'label' => 'Layanan', 'val' => 'Fast Response', 'sub' => 'Friendly Chat']
                    ];
                @endphp

                @foreach($infos as $info)
                <div class="fade-up group bg-white p-5 rounded-[1.5rem] border border-neutral-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-500 ease-[cubic-bezier(0.34,1.56,0.64,1)]">
                    <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center text-xl mb-4 mx-auto group-hover:scale-110 group-hover:bg-orange-100 transition-all duration-500">
                        {{ $info['icon'] }}
                    </div>
                    <p class="text-[8px] text-neutral-400 uppercase tracking-widest font-black mb-1">{{ $info['label'] }}</p>
                    <p class="text-[11px] font-bold text-neutral-800">
                        {{ $info['val'] }}<br>
                        <span class="text-orange-500 font-light italic">{{ $info['sub'] }}</span>
                    </p>
                </div>
                @endforeach
            </div>

            {{-- Main Action Button --}}
            <div class="pt-4 fade-up">
                <a href="https://wa.me/6281234567890?text=Halo%20CafeKu,%20saya%20ingin%20reservasi%20tempat"
                   target="_blank"
                   class="group relative inline-flex items-center gap-3 px-8 py-4 bg-neutral-950 text-white rounded-full overflow-hidden transition-all duration-700 hover:shadow-[0_20px_40px_rgba(37,211,102,0.3)] active:scale-95">
                    
                    <div class="absolute inset-0 w-full h-full bg-[#25D366] translate-y-full group-hover:translate-y-0 transition-transform duration-500 ease-[cubic-bezier(0.19,1,0.22,1)]"></div>
                    
                    <span class="relative z-10 flex items-center gap-2">
                        <svg class="w-4 h-4 fill-current group-hover:rotate-[12deg] transition-transform duration-500" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        <span class="text-[10px] font-black uppercase tracking-[0.2em]">Hubungi WhatsApp</span>
                    </span>
                </a>

                <div class="mt-3 flex flex-col items-center gap-2">
                    <p class="text-[8px] text-neutral-400 font-bold uppercase tracking-[0.3em] animate-pulse">
                        Respons ± 1-5 Menit
                    </p>
                </div>
            </div>

            {{-- Social Links --}}
            <div class="flex flex-wrap justify-center gap-2 pt-4 fade-up">
                @foreach(['Instagram', 'TikTok', 'Facebook'] as $social)
                <a href="#" class="px-5 py-2 text-[8px] font-black uppercase tracking-widest rounded-full border border-neutral-100 text-neutral-400 hover:text-white hover:bg-orange-500 hover:border-orange-500 transition-all duration-500">
                    {{ $social }}
                </a>
                @endforeach
            </div>

        </div>
    </div>
</section>

<style>
    /* Smooth Entrance */
    .fade-up {
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.8s cubic-bezier(0.22, 1, 0.36, 1);
    }
    
    .fade-up.is-visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* Staggered Delay for Cards */
    .stagger-container .fade-up:nth-child(1) { transition-delay: 100ms; }
    .stagger-container .fade-up:nth-child(2) { transition-delay: 200ms; }
    .stagger-container .fade-up:nth-child(3) { transition-delay: 300ms; }

    /* Keyframes */
    @keyframes drift {
        0%, 100% { transform: translate(0, 0) scale(1); }
        50% { transform: translate(30px, -20px) scale(1.1); }
    }
    
    @keyframes grow-line {
        from { transform: scaleX(0); }
        to { transform: scaleX(1); }
    }

    .animate-drift { animation: drift 10s ease-in-out infinite; }
    .animate-drift-slow { animation: drift 15s ease-in-out infinite reverse; }
    .animate-grow-line { animation: grow-line 1s ease-out forwards; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if(entry.isIntersecting){
                    entry.target.classList.add('is-visible');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));
    });
</script>

@endsection