@extends('layouts.app')
<title>CafeKu - Pembayaran Berhasil</title>
@section('content')
<div class="bg-[#fafafa] min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-[32px] shadow-2xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
        
        {{-- Header Status --}}
        <div class="p-8 text-center bg-gray-900 text-white">
            <div class="w-16 h-16 bg-orange-600 rounded-2xl flex items-center justify-center mx-auto mb-4 rotate-3 shadow-lg">
                <span class="text-3xl">✅</span>
            </div>
            <h1 class="text-xl font-black uppercase tracking-tighter">Pesanan Berhasil!</h1>
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-1">Order ID: #{{ $order->order_number }}</p>
        </div>

        <div class="p-8">
            {{-- KONDISI 1: BAYAR DI KASIR --}}
            @if($order->payment_method === 'cash')
                <div class="text-center space-y-4">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Tunjukkan kode ini ke kasir:</p>
                    <div class="bg-gray-50 p-6 rounded-2xl border-2 border-dashed border-gray-200">
                        <span class="text-4xl font-black tracking-[0.2em] text-gray-900">{{ $order->order_number }}</span>
                    </div>
                    <p class="text-[9px] text-orange-600 font-black uppercase tracking-widest">⚠️ Pesanan akan dimasak setelah pembayaran</p>
                </div>

            {{-- KONDISI 2: QRIS / E-WALLET --}}
            @elseif(in_array($order->payment_method, ['qris', 'ovo', 'dana', 'gopay', 'shopeepay']))
                <div class="text-center space-y-4">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Scan QRIS di bawah ini:</p>
                    <div class="bg-white p-4 border-2 border-gray-900 rounded-3xl inline-block shadow-xl">
                        {{-- Contoh QRIS Statis, nanti bisa diganti API Midtrans --}}
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=PAYMENT-{{ $order->order_number }}" 
                             alt="QRIS Payment" class="w-48 h-48 mx-auto">
                    </div>
                    <div class="flex items-center justify-center gap-2">
                        <span class="px-2 py-1 bg-blue-100 text-blue-600 rounded text-[8px] font-black uppercase">Gopay</span>
                        <span class="px-2 py-1 bg-purple-100 text-purple-600 rounded text-[8px] font-black uppercase">OVO</span>
                        <span class="px-2 py-1 bg-blue-50 text-blue-500 rounded text-[8px] font-black uppercase">DANA</span>
                    </div>
                </div>

            {{-- KONDISI 3: VIRTUAL ACCOUNT --}}
            @else
                <div class="text-center space-y-4">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Nomor Virtual Account:</p>
                    <div class="bg-blue-50 p-6 rounded-2xl border-2 border-blue-200 text-blue-900">
                        <p class="text-[10px] font-black uppercase opacity-60">{{ strtoupper($order->payment_method) }}</p>
                        <span class="text-2xl font-black tracking-widest">883208{{ rand(1000,9999) }}77</span>
                    </div>
                    <button class="text-[10px] font-black text-blue-600 uppercase underline">Salin Nomor VA</button>
                </div>
            @endif

            <hr class="my-8 border-gray-100">

            {{-- Ringkasan Singkat --}}
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-[10px] font-bold text-gray-400 uppercase">Metode</span>
                    <span class="text-[10px] font-black text-gray-900 uppercase">
                        {{ $order->service_type === 'delivery' ? '🚚 Delivery' : '🍽️ Dine-In' }}
                    </span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-[10px] font-bold text-gray-400 uppercase">Total Bayar</span>
                    <span class="text-sm font-black text-orange-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
                @if($order->service_type === 'delivery')
                <div class="bg-orange-50 p-3 rounded-xl">
                    <p class="text-[9px] font-bold text-orange-700 leading-relaxed uppercase">
                        📍 Pesanan akan diantar ke:<br>
                        <span class="text-gray-900 italic font-medium normal-case">{{ $order->address }}</span>
                    </p>
                </div>
                @endif
            </div>

            {{-- Action Buttons --}}
            <div class="mt-8 space-y-3">
                <a href="/" class="block w-full py-4 bg-gray-900 text-white rounded-2xl text-center text-[10px] font-black uppercase tracking-widest hover:bg-orange-600 transition-all">
                    Kembali Ke Beranda
                </a>
                <button onclick="window.print()" class="block w-full py-3 bg-white border border-gray-200 text-gray-400 rounded-2xl text-center text-[9px] font-black uppercase tracking-widest hover:text-gray-900 transition-all">
                    Cetak Struk (PDF)
                </button>
            </div>
        </div>

        {{-- Footer dekorasi --}}
        <div class="p-4 bg-gray-50 text-center">
            <p class="text-[8px] font-bold text-gray-300 uppercase tracking-[0.3em]">Terima Kasih Telah Memesan</p>
        </div>
    </div>
</div>
@endsection