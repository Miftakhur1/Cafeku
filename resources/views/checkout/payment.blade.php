@extends('layouts.app')
<title>CafeKu - Pembayaran</title>
@section('content')
<div class="bg-[#fafafa] min-h-screen py-6 px-4">
    {{-- Lebar max dikurangi dari max-w-lg ke max-w-md --}}
    <div class="max-w-md mx-auto bg-white rounded-[24px] shadow-sm border border-gray-100 overflow-hidden">
        
        {{-- Header lebih pendek --}}
        <div class="p-6 text-center border-b border-gray-50">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-orange-50 text-orange-600 rounded-full mb-3">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-orange-500"></span>
                </span>
                <span class="text-[8px] font-black uppercase tracking-widest">Menunggu Pembayaran</span>
            </div>
            <h1 class="text-xl font-black text-gray-900 leading-none uppercase">Pembayaran</h1>
        </div>

        <div class="p-6">
            {{-- Section Kode Pesanan lebih ringkas --}}
            <div class="bg-orange-50 border border-dashed border-orange-200 rounded-[20px] p-4 mb-6 text-center">
                <p class="text-[9px] font-black text-orange-700 uppercase tracking-wider mb-2">Nomor Pesanan Anda</p>
                
                <div class="bg-white py-3 px-2 rounded-xl shadow-sm mb-3">
                    <h3 class="text-2xl font-black text-gray-900 tracking-widest italic" id="orderNum">
                        {{ $order->order_number }}
                    </h3>
                </div>

                <div class="flex flex-col gap-2">
                    <button onclick="copyToClipboard()" class="w-full py-2 bg-white border border-gray-200 rounded-lg text-[9px] font-black uppercase tracking-widest text-gray-700 hover:bg-gray-50 transition-all flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        Salin Kode
                    </button>
                </div>
            </div>

            {{-- Area Detail Pembayaran --}}
            @if($order->payment_method === 'cash')
                <div class="text-center space-y-4">
                    <div class="bg-gray-900 p-6 rounded-[20px] text-white">
                        <p class="text-[9px] font-bold opacity-60 uppercase mb-1">Total Tagihan</p>
                        <h2 class="text-2xl font-black italic">Rp {{ number_format($order->total_price, 0, ',', '.') }}</h2>
                    </div>
                    <p class="text-[9px] font-black text-gray-400 uppercase">Tunjukkan kode di atas ke Kasir</p>
                </div>
            @else
                <div class="text-center space-y-4">
                    {{-- QR Code diperkecil --}}
                    <div class="inline-block p-3 bg-white border-2 border-gray-900 rounded-[24px] shadow-lg">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $order->order_number }}" class="w-32 h-32">
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Metode: {{ strtoupper($order->payment_method) }}</p>
                        <h2 class="text-xl font-black text-orange-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</h2>
                    </div>
                </div>
            @endif

            {{-- Info & Navigasi --}}
            <div class="mt-8 pt-5 border-t border-gray-100">
                <div class="flex items-start gap-3 mb-6 bg-blue-50 p-3 rounded-xl">
                    <div class="text-lg">ℹ️</div>
                    <p class="text-[8px] font-bold text-blue-800 leading-relaxed uppercase tracking-wide">
                        Pesanan diproses setelah konfirmasi kasir. Cek status di menu "Lacak Pesanan".
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('order.track.index') }}" class="py-3 bg-orange-600 text-white text-center rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-orange-700 transition-all shadow-md shadow-orange-100">
                        Lacak
                    </a>
                    <a href="{{ route('landing') }}" class="py-3 bg-gray-100 text-gray-400 text-center rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-gray-200 transition-all">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard() {
    const text = document.getElementById('orderNum').innerText;
    navigator.clipboard.writeText(text).then(() => {
        alert('Disalin: ' + text);
    });
}
</script>
@endsection