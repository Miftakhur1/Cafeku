@extends('layouts.app')
<title>CafeKu - Pelacakan Pesanan</title>
@section('content')
<div class="min-h-screen bg-[#f8fafc] py-12 px-4">
    <div class="max-w-2xl mx-auto">
        
        {{-- SEARCH SECTION: Compact & Minimalist --}}
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 mb-6">
            <form action="{{ route('order.track.search') }}" method="GET" class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" name="order_number" 
                       class="block w-full pl-10 pr-32 py-2.5 bg-slate-50 border border-slate-200 rounded-lg focus:ring-1 focus:ring-slate-400 focus:border-slate-400 outline-none transition-all text-sm font-mono tracking-wider uppercase" 
                       placeholder="INPUT TRACKING NUMBER..." 
                       value="{{ request('order_number') }}">
                <button type="submit" class="absolute right-1.5 top-1.5 bg-orange-600 hover:bg-orange-700 text-white text-[10px] font-black px-5 py-1.5 rounded-md transition-all shadow-sm shadow-orange-200 active:scale-95 tracking-widest uppercase">
                    TRACK
                </button>
            </form>
            @if(session('error'))
                <p class="text-red-500 text-[11px] mt-2 ml-1 font-medium italic">* {{ session('error') }}</p>
            @endif
        </div>

        @if(isset($order))
        {{-- MAIN CONTENT: Profesional Card --}}
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            
            {{-- Header: Status & ID --}}
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                <div>
                    <h2 class="text-slate-800 font-bold text-lg leading-none">Order Details</h2>
                    <p class="text-slate-400 text-[11px] mt-1 font-mono">ID: #{{ $order->order_number }}</p>
                </div>
                <div class="text-right">
                    <span class="text-[10px] font-black px-3 py-1 rounded tracking-widest uppercase
                        @if($order->status == 'pending' || $order->status == 'belum bayar') bg-amber-50 text-amber-600 border border-amber-200
                        @elseif($order->status == 'completed' || $order->status == 'selesai') bg-emerald-50 text-emerald-600 border border-emerald-200
                        @else bg-blue-50 text-blue-600 border border-blue-200 @endif">
                        {{ $order->status }}
                    </span>
                </div>
            </div>

            {{-- Customer & Service Info --}}
            <div class="px-6 py-4 bg-slate-50/50 grid grid-cols-2 gap-8 border-b border-slate-100">
                <div class="space-y-1">
                    <p class="text-slate-400 text-[10px] uppercase font-bold tracking-wider">Customer Info</p>
                    <p class="text-slate-700 text-sm font-medium">{{ $order->customer_name }}</p>
                </div>
                <div class="space-y-1 text-right">
                    <p class="text-slate-400 text-[10px] uppercase font-bold tracking-wider">Service Mode</p>
                    <p class="text-slate-700 text-sm font-medium">
                        {{ ucfirst($order->service_type) }} {{ $order->table_number ? '— Table '.$order->table_number : '' }}
                    </p>
                </div>
            </div>

            {{-- Items Table: Sleek Design --}}
            <div class="p-6">
                <table class="w-full">
                    <thead>
                        <tr class="text-left border-b border-slate-100">
                            <th class="pb-3 text-slate-400 text-[10px] uppercase font-black">Particulars</th>
                            <th class="pb-3 text-slate-400 text-[10px] uppercase font-black text-center">Qty</th>
                            <th class="pb-3 text-slate-400 text-[10px] uppercase font-black text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($order->items as $item)
                        <tr class="group">
                            <td class="py-4">
                                <div class="font-semibold text-slate-800 text-sm group-hover:text-slate-600 transition-colors">
                                    {{ $item->product->name ?? 'Unidentified Item' }}
                                </div>
                                <div class="text-slate-400 text-[10px] mt-0.5 font-medium italic">
                                    Unit Price: Rp {{ number_format($item->unit_price ?? $item->price, 0, ',', '.') }}
                                </div>
                            </td>
                            <td class="py-4 text-center text-slate-600 text-sm font-bold">
                                {{ $item->quantity }}
                            </td>
                            <td class="py-4 text-right text-slate-800 text-sm font-bold">
                                Rp {{ number_format($item->quantity * ($item->unit_price ?? $item->price), 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Summary & Action --}}
            <div class="px-6 py-5 bg-slate-50 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="text-center sm:text-left">
                    <p class="text-slate-400 text-[10px] uppercase font-bold tracking-widest leading-none">Amount Due</p>
                    <p class="text-2xl font-black text-slate-900 mt-1">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                </div>

                @if($order->status == 'pending' || $order->status == 'belum bayar')
                    <button onclick="openQrisModal()" 
                            class="w-full sm:w-auto bg-slate-900 hover:bg-black text-white text-xs font-black py-3 px-10 rounded shadow-sm transition-all active:scale-95 tracking-widest uppercase">
                        Proceed to Payment
                    </button>
                @else
                    <div class="flex items-center space-x-2 text-emerald-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        <span class="text-xs font-bold uppercase tracking-widest">Transaction Settled</span>
                    </div>
                @endif
            </div>
        </div>
        @endif

    </div>
</div>

{{-- MODAL QRIS: Professional & Focused --}}
<div id="modalQris" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-[2px]" onclick="closeQrisModal()"></div>

    <div class="relative bg-white rounded-lg shadow-2xl max-w-[320px] w-full p-8 text-center animate-in zoom-in duration-200">
        <h3 class="text-slate-800 text-sm font-black uppercase tracking-[0.2em] mb-6 border-b pb-2 border-slate-100">QRIS Payment</h3>
        
        <div class="bg-white p-2 border border-slate-100 inline-block mb-6 shadow-sm">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=PAY_ORDER_{{ $order->order_number ?? '' }}" 
                 class="w-44 h-44 grayscale hover:grayscale-0 transition-all" alt="QRIS">
        </div>

        <div class="mb-8">
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest leading-none">Total Amount</p>
            <p class="text-xl font-black text-slate-900 mt-1">Rp {{ isset($order) ? number_format($order->total_price, 0, ',', '.') : '0' }}</p>
        </div>

        <button onclick="closeQrisModal()" class="w-full border-2 border-slate-900 text-slate-900 font-bold py-2 rounded text-xs hover:bg-slate-900 hover:text-white transition-all uppercase tracking-widest">
            Close Window
        </button>
        <p class="mt-4 text-[9px] text-slate-400 leading-relaxed font-medium uppercase tracking-tighter">
            System will update automatically after validation.
        </p>
    </div>
</div>

<script>
    function openQrisModal() {
        document.getElementById('modalQris').classList.remove('hidden');
    }
    function closeQrisModal() {
        document.getElementById('modalQris').classList.add('hidden');
    }
</script>
@endsection