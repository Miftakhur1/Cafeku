@extends('layouts.app')
@section('title', 'CafeKu - Tentang Kami')

<link rel="icon" type="image/svg+xml" href="{{ asset('images/gemini-svg.svg') }}">
@include('partials.chatbot')

@section('content')

<div class="bg-[#FDFDFD] text-[#1a1a1a] font-sans selection:bg-orange-100 selection:text-orange-900 overflow-x-hidden">

    <section class="flex flex-col justify-end px-4 sm:px-6 md:px-16 pb-12 pt-24 md:pt-32 relative border-b border-neutral-100 min-h-[50vh] md:min-h-[70vh]">
        {{-- Background Text diperkecil agar tidak terlalu mendominasi --}}
        <div class="absolute top-10 right-0 text-[20vw] md:text-[12vw] font-black text-neutral-50 select-none z-0 leading-none tracking-tighter pointer-events-none uppercase">
            SRG.
        </div>

        <div class="max-w-6xl mx-auto w-full relative z-10">
            <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)"
                 x-show="show" x-transition:enter="transition cubic-bezier(0.4, 0, 0.2, 1) duration-700 transform"
                 x-transition:enter-start="opacity-0 translate-y-8">
                
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                    <h1 class="text-5xl sm:text-6xl md:text-[7vw] lg:text-[8vw] font-black leading-[0.9] md:leading-[0.8] tracking-tighter uppercase italic">
                        PURE <br> <span class="text-orange-600 not-italic">HONESTY.</span>
                    </h1>
                    
                    <div class="pb-2 hidden md:block">
                        <div class="flex items-center gap-3 text-[8px] font-black uppercase tracking-[0.4em] text-neutral-300">
                            <span class="w-6 h-[1px] bg-neutral-200"></span>
                            Scroll to Explore
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mt-6 md:mt-8 items-start border-t border-neutral-100 pt-6">
                    <div class="lg:col-span-8">
                        <p class="text-lg sm:text-xl md:text-2xl font-light leading-tight tracking-tight text-neutral-500 max-w-2xl">
                            Mendefinisikan kembali <span class="text-black font-medium relative italic inline-block">hubungan<span class="absolute bottom-1 left-0 w-full h-[1.5px] bg-orange-500/20"></span></span> antara petani, penyeduh, dan penikmat setia.
                        </p>
                    </div>
                    <div class="lg:col-span-4 flex justify-start md:justify-end">
                        <p class="text-[9px] leading-relaxed text-neutral-400 uppercase tracking-[0.3em] font-black text-left md:text-right">
                            Semarang, Indonesia <br> 
                            <span class="text-orange-500">Est. MMXXIII</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 md:py-20 px-4 sm:px-6 md:px-16 bg-white">
        <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            
            <div class="lg:col-span-5 relative group order-2 lg:order-1">
                <div class="aspect-square lg:aspect-[4/5] rounded-xl overflow-hidden shadow-xl relative max-w-sm mx-auto lg:max-w-none">
                    <img src="{{ asset('storage/umkm/profill.jpg') }}" alt="About Us Image" 
                         class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-105 transition-all duration-1000 ease-out">
                </div>
                <div class="absolute -bottom-3 -right-2 md:-right-3 bg-white p-4 shadow-lg border border-neutral-50 rounded-sm">
                    <p class="text-[7px] font-black uppercase tracking-[0.4em] text-orange-500 mb-0.5">Status</p>
                    <p class="text-[10px] font-bold italic tracking-tighter uppercase">Small Batch Roasting</p>
                </div>
            </div>

            <div class="lg:col-span-6 lg:col-start-8 order-1 lg:order-2">
                <div class="space-y-6">
                    <div class="space-y-2">
                        <h2 class="text-[8px] font-black uppercase tracking-[0.6em] text-neutral-300">Identity / 01</h2>
                        <h3 class="text-3xl md:text-4xl lg:text-5xl font-black tracking-tighter uppercase leading-[1]">
                            KEJUJURAN <br> <span class="italic font-light text-orange-600">DALAM PROSES.</span>
                        </h3>
                    </div>

                    <div class="space-y-4 text-neutral-500 leading-relaxed font-medium text-sm md:text-base">
                        <p>
                            Filosofi kami berakar pada transparansi. Kami tidak menyembunyikan rasa di balik campuran gula yang berlebihan. Kami membiarkan biji kopi berbicara tentang tanah asalnya.
                        </p>
                        <div class="bg-[#FAFAFA] p-6 rounded-r-lg border-l-2 border-black">
                             <p class="text-black font-semibold text-sm md:text-base italic leading-snug">
                                "Kopi yang baik tidak butuh penjelasan rumit, ia hanya butuh penikmat yang menghargai waktu."
                            </p>
                        </div>
                    </div>

                    <div class="pt-2">
                        <a href="https://wa.me/6281234567890" class="group inline-flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full border border-neutral-200 flex items-center justify-center group-hover:bg-black group-hover:text-white group-hover:border-black transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </div>
                            <span class="text-[9px] font-black uppercase tracking-[0.3em] group-hover:text-orange-600 transition-colors">Contact Us</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-10 border-y border-neutral-100 px-4 sm:px-6 md:px-16 bg-[#FDFDFD]">
        <div class="max-w-6xl mx-auto flex flex-wrap justify-between gap-6">
            @php
                $stats = [
                    ['label' => 'Farmers', 'value' => '12', 'suffix' => '+'],
                    ['label' => 'Origins', 'value' => 'Java', 'suffix' => '.'],
                    ['label' => 'Success', 'value' => '99.8', 'suffix' => '%'],
                    ['label' => 'Since', 'value' => 'MMXXIII', 'suffix' => '']
                ];
            @endphp
            @foreach($stats as $stat)
            <div class="min-w-[100px]">
                <p class="text-[7px] font-black uppercase tracking-[0.3em] text-neutral-300 mb-1">
                    {{ $stat['label'] }}
                </p>
                <p class="text-xl md:text-2xl font-black tracking-tighter uppercase {{ $loop->index % 2 == 1 ? 'italic text-orange-600' : '' }}">
                    {{ $stat['value'] }}<span class="text-orange-500 text-xs italic">{{ $stat['suffix'] }}</span>
                </p>
            </div>
            @endforeach
        </div>
    </section>

    <section class="py-20 md:py-24 px-4 text-center bg-white">
        <div class="max-w-2xl mx-auto">
            <div class="flex justify-center items-center gap-1.5 mb-6">
                <span class="w-1 h-1 rounded-full bg-orange-500 animate-pulse"></span>
                <span class="w-1 h-1 rounded-full bg-orange-500 animate-pulse" style="animation-delay: 0.2s"></span>
                <span class="w-1 h-1 rounded-full bg-orange-500 animate-pulse" style="animation-delay: 0.4s"></span>
            </div>
            
            <h2 class="text-4xl sm:text-5xl md:text-6xl font-black tracking-tighter uppercase leading-[0.9] mb-8">
                VISIT THE <br> <span class="text-orange-600 italic">SANCTUARY.</span>
            </h2>
            
            <a href="https://wa.me/6281234567890" 
               class="group relative inline-flex items-center justify-center px-10 py-4 bg-black text-white rounded-full overflow-hidden transition-all duration-500 active:scale-95 shadow-xl">
                <div class="absolute inset-0 w-full h-full bg-orange-600 -translate-x-full group-hover:translate-x-0 transition-transform duration-500"></div>
                <span class="relative z-10 text-[9px] font-black uppercase tracking-[0.4em]">Book Your Seat</span>
            </a>
            
            <div class="mt-16 flex flex-col items-center gap-3">
                <div class="h-[1px] w-8 bg-neutral-200"></div>
                <p class="text-[8px] font-black uppercase tracking-[0.4em] text-neutral-300">CafeKu — Semarang</p>
            </div>
        </div>
    </section>

</div>

@endsection