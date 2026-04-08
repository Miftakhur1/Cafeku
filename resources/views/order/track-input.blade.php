@extends('layouts.app')
<title> CafeKu - Pelacakan Pesanan</title>
@section('content')
<div class="min-h-screen bg-gray-50 flex flex-col items-center justify-start px-4 py-12 font-sans">
    
    <div class="max-w-3xl w-full space-y-6">
        
        {{-- CARD INPUT: Disesuaikan dengan UI Result --}}
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 transition-all">
            {{-- Header Input Ala Shopee --}}
            <div class="px-6 py-3 border-b border-gray-50 flex justify-between items-center bg-white">
                <div class="flex items-center space-x-2">
                    <span class="bg-orange-600 text-white text-[10px] px-1 rounded-sm font-bold tracking-tighter uppercase">Sistem</span>
                    <span class="font-bold text-sm text-gray-800 tracking-tight">Pelacakan Pesanan</span>
                </div>
                <div class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">
                    Cek Status Real-time
                </div>
            </div>

            {{-- Body Input --}}
            <div class="p-6 bg-white">
                <form action="{{ route('order.track.search') }}" method="GET" class="flex flex-col md:flex-row gap-3">
                    <div class="relative flex-1">
                        <input type="text" 
                               name="order_number" 
                               placeholder="Contoh: ORD-20231001" 
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none uppercase font-mono text-sm transition-all shadow-inner"
                               value="{{ request('order_number') }}"
                               required>
                    </div>
                    <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white px-10 py-3 rounded-lg font-black text-xs tracking-widest transition-all shadow-lg shadow-orange-100 active:scale-95 uppercase">
                        Cari Pesanan
                    </button>
                </form>

                {{-- Info Box Profesional --}}
                <div class="mt-4 flex items-start space-x-3 p-4 bg-orange-50/50 rounded-xl border border-orange-100">
                    <div class="bg-orange-100 p-1.5 rounded-full">
                        <svg class="w-4 h-4 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="text-[11px] text-orange-800 leading-relaxed">
                        <strong>Informasi:</strong> Masukkan <strong>ID Pesanan</strong> yang tertera pada nota atau layar pemesanan Anda untuk melihat rincian menu dan melakukan pembayaran QRIS.
                    </div>
                </div>
            </div>

            @if(session('error'))
                <div class="px-6 pb-4">
                    <p class="text-red-500 text-[11px] text-center font-bold bg-red-50 py-2 rounded-lg border border-red-100">
                        ⚠️ {{ session('error') }}
                    </p>
                </div>
            @endif
        </div>

        {{-- STATE SAAT BELUM CARI --}}
        @if(!isset($order))
            <div class="text-center py-20 bg-white rounded-xl border border-dashed border-gray-200 shadow-sm">
                <div class="inline-block p-5 bg-orange-50 rounded-full mb-4 animate-bounce">
                    <svg class="w-10 h-10 text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <h3 class="text-gray-800 font-black text-sm uppercase tracking-widest">Siap Melacak?</h3>
                <p class="text-gray-400 text-[10px] max-w-xs mx-auto mt-2 font-medium leading-relaxed">
                    Data pesanan, status dapur, dan QRIS pembayaran akan muncul secara otomatis setelah nomor pesanan divalidasi.
                </p>
            </div>
        @endif

        {{-- HASIL PENCARIAN (SAMA SEPERTI SEBELUMNYA) --}}
        @if(isset($order))
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 transition-all duration-500 animate-in fade-in slide-in-from-bottom-4">
                <div class="px-6 py-4 border-b border-gray-50 flex justify-between items-center bg-white">
                    <div class="flex items-center space-x-2">
                        <span class="bg-orange-600 text-white text-[10px] px-1 rounded-sm font-bold tracking-tighter uppercase">Merchant</span>
                        <span class="font-bold text-sm text-gray-800 tracking-tight">Kantin Digital</span> 
                    </div>
                    <div class="flex items-center text-teal-600 font-bold text-[10px] uppercase tracking-wider">
                        <span class="flex h-2 w-2 rounded-full bg-teal-500 mr-2 animate-pulse"></span>
                        Status: {{ $order->status }}
                    </div>
                </div>

                <div class="p-6 space-y-5">
                    @foreach($order->items as $item)
                    <div class="flex space-x-4 border-b border-gray-50 pb-4 last:border-0 last:pb-0 group">
                        <div class="w-16 h-16 bg-gray-50 rounded-lg border border-gray-100 flex-shrink-0 overflow-hidden shadow-sm">
                            @if($item->product_image)
                                <img src="{{ asset('storage/'.$item->product_image) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-bold text-gray-800 truncate group-hover:text-orange-600 transition-colors">{{ $item->product_name }}</h4>
                            <p class="text-[11px] text-gray-400 mt-0.5">Catatan: {{ $item->variation ?? 'Tanpa variasi' }}</p>
                            <p class="text-xs mt-1 text-gray-600 font-medium italic">Qty: x{{ $item->quantity }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-800 font-black">Rp{{ number_format($item->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="px-6 py-6 bg-slate-50/80 border-t border-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <div class="text-[10px] text-gray-400 font-black uppercase tracking-widest italic">Order ID #{{ $order->order_number }}</div>
                        <div class="text-right">
                            <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest block leading-none mb-1">Total Tagihan</span>
                            <span class="text-2xl font-black text-orange-600 tracking-tighter">Rp{{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-3">
                        @if($order->status == 'pending' || $order->status == 'belum bayar')
                            <button onclick="openModalQris()" class="col-span-2 bg-orange-600 hover:bg-orange-700 text-white py-4 rounded-xl font-black text-xs tracking-[0.2em] shadow-xl shadow-orange-100 transition-all active:scale-95 uppercase">
                                Bayar Sekarang (QRIS)
                            </button>
                        @endif
                        <button class="px-4 py-3 bg-white border border-gray-200 rounded-xl text-[10px] font-black text-gray-500 hover:bg-gray-50 uppercase tracking-widest transition-all">
                            Hubungi Admin
                        </button>
                        <button class="px-4 py-3 bg-white border border-gray-200 rounded-xl text-[10px] font-black text-gray-500 hover:bg-gray-50 uppercase tracking-widest transition-all">
                            Simpan Struk
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>

</div>

{{-- MODAL QRIS --}}
<div id="modalQris" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/80 backdrop-blur-sm">
    <div class="bg-white rounded-3xl w-full max-w-sm p-8 text-center animate-in zoom-in duration-300 shadow-2xl">
        <h3 class="text-sm font-black text-gray-400 mb-2 uppercase tracking-[0.3em]">QRIS Payment</h3>
        <p class="text-lg font-black text-gray-900 mb-6 tracking-tight">Order #{{ $order->order_number ?? '' }}</p>
        
        <div class="bg-white p-3 border border-gray-100 rounded-2xl inline-block mb-6 shadow-sm">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=QRIS_PAY_{{ $order->order_number ?? '' }}" class="w-52 h-52">
        </div>

        <div class="mb-8">
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">Total yang harus dibayar</p>
            <p class="text-3xl font-black text-orange-600 tracking-tighter">Rp{{ isset($order) ? number_format($order->total_price, 0, ',', '.') : '0' }}</p>
        </div>

        <button onclick="closeModalQris()" class="w-full bg-gray-900 text-white py-4 rounded-2xl font-black text-xs tracking-widest hover:bg-gray-800 transition-all uppercase">
            Tutup Pembayaran
        </button>
    </div>
</div>

<script>
    function openModalQris() {
        document.getElementById('modalQris').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function closeModalQris() {
        document.getElementById('modalQris').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
</script>
@endsection