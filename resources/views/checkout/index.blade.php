@extends('layouts.app')
<title>CafeKu - Finalisasi Pesanan</title>
@section('content')
<div class="bg-[#fafafa] min-h-screen pb-20" 
     x-data="{ 
        customerName: '',
        serviceType: 'dine-in', 
        paymentMethod: 'qris',
        address: '', 
        isLocating: false,
        isSubmitting: false,
        subtotal: {{ $subtotal }},
        tax: {{ $subtotal * 0.1 }},
        
        get shipping() {
            if (this.serviceType !== 'delivery' || this.address === '') return 0;
            return this.address.toLowerCase().includes('semarang') ? 0 : 15000;
        },

        async submitForm() {
            this.isSubmitting = true;
            // Optional: Add any client-side validation here
            document.querySelector('form').submit();
        },

        getLocation() {
            this.isLocating = true;
            if (!navigator.geolocation) {
                alert('Browser tidak mendukung GPS');
                this.isLocating = false;
                return;
            }
            navigator.geolocation.getCurrentPosition(async (position) => {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                try {
                    const response = await fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`);
                    const data = await response.json();
                    this.address = data.display_name;
                } catch (e) { this.address = `${lat}, ${lng}`; }
                this.isLocating = false;
            }, () => {
                alert('Gagal ambil lokasi');
                this.isLocating = false;
            });
        }
     }">
    
    <div class="max-w-6xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-black text-gray-900 uppercase tracking-tighter mb-8">Finalisasi <span class="text-orange-600">Pesanan</span></h1>
        {{-- Info Cards: Tahapan Belanja --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-10">
            <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex items-start gap-4 opacity-60">
                <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center shrink-0 text-lg">🛒</div>
                <div>
                    <h4 class="text-[10px] font-black uppercase tracking-widest text-gray-900">1. Konfirmasi</h4>
                    <p class="text-[10px] text-gray-400 font-bold leading-relaxed mt-1 uppercase italic">Cek kembali item di keranjang.</p>
                </div>
            </div>
            <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex items-start gap-4 ring-2 ring-orange-500/5">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center shrink-0 text-lg">📝</div>
                <div>
                    <h4 class="text-[10px] font-black uppercase tracking-widest text-gray-900">2. Isi Data</h4>
                    <p class="text-[10px] text-gray-400 font-bold leading-relaxed mt-1 uppercase">Nama & nomor meja/HP anda.</p>
                </div>
            </div>
            <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex items-start gap-4 opacity-60">
                <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center shrink-0 text-lg">✅</div>
                <div>
                    <h4 class="text-[10px] font-black uppercase tracking-widest text-gray-900">3. Bayar</h4>
                    <p class="text-[10px] text-gray-400 font-bold leading-relaxed mt-1 uppercase">Dapatkan kode untuk melacak.</p>
                </div>
            </div>
        </div>

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <div class="flex flex-col lg:flex-row gap-8">
                
                {{-- KOLOM KIRI --}}
                <div class="flex-grow space-y-6">
                    
                    {{-- 1. PILIH LAYANAN --}}
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                        <h2 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">1. Metode Pesanan</h2>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="cursor-pointer">
                                <input type="radio" name="service_type" value="dine-in" x-model="serviceType" class="hidden">
                                <div :class="serviceType === 'dine-in' ? 'border-orange-500 bg-orange-50 text-orange-600' : 'border-gray-100 text-gray-400'" class="p-4 border-2 rounded-xl text-center font-black text-[10px] uppercase transition-all">Makan Di Tempat</div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="service_type" value="delivery" x-model="serviceType" @change="paymentMethod = 'qris'" class="hidden">
                                <div :class="serviceType === 'delivery' ? 'border-orange-500 bg-orange-50 text-orange-600' : 'border-gray-100 text-gray-400'" class="p-4 border-2 rounded-xl text-center font-black text-[10px] uppercase transition-all">Delivery Antar</div>
                            </label>
                        </div>
                    </div>

                    {{-- 2. DETAIL PENERIMA --}}
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                        <h2 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">2. Data Pelanggan</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 uppercase">Nama Lengkap</label>
                                <input type="text" 
                                    name="customer_name" 
                                    x-model="customerName" required 
                                    minlength="2" 
                                    class="w-full px-4 py-3 rounded-xl bg-gray-50 border-none text-sm font-bold focus:ring-2 focus:ring-orange-500" 
                                    placeholder="Masukkan Nama ">
                                    @error('customer_name')
                                <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span>
                            @enderror
                            </div>
                            <div x-show="serviceType === 'dine-in'">
                                <label class="text-[10px] font-bold text-gray-400 uppercase">Nomor Meja</label>
                                <input type="number" name="table_number" placeholder="No.Meja Anda" class="w-full px-4 py-3 rounded-xl bg-gray-50 border-none text-sm font-bold focus:ring-2 focus:ring-orange-500">
                            </div>
                            <div x-show="serviceType === 'delivery'">
                                <label class="text-[10px] font-bold text-gray-400 uppercase">WhatsApp</label>
                                <input type="tel" name="phone" placeholder="08..." pattern="[0-9]{10,13}" class="w-full px-4 py-3 rounded-xl bg-gray-50 border-none text-sm font-bold focus:ring-2 focus:ring-orange-500">
                            </div>
                        </div>

                        <div class="mt-4" x-show="serviceType === 'delivery'" x-transition>
                            <div class="flex justify-between items-center mb-1">
                                <label class="text-[10px] font-bold text-gray-400 uppercase">Alamat Lengkap</label>
                                <button type="button" @click="getLocation()" class="text-[9px] font-black text-orange-600 uppercase hover:underline">
                                    <span x-show="!isLocating">📍 Deteksi Lokasi</span>
                                    <span x-show="isLocating">⌛ Mencari...</span>
                                </button>
                            </div>
                            <textarea x-model="address" name="address" rows="3"  class="w-full px-4 py-3 rounded-xl bg-gray-50 border-none text-sm font-medium focus:ring-2 focus:ring-orange-500" placeholder="Ketik alamat atau gunakan deteksi lokasi..."></textarea>
                        </div>
                    </div>
                    

                    {{-- 3. METODE PEMBAYARAN --}}
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-[10px] font-black text-gray-400 uppercase tracking-widest">3. Cara Bayar</h2>
                            <span x-show="serviceType === 'delivery'" class="text-[9px] font-black text-orange-600 bg-orange-50 px-2 py-1 rounded-md uppercase tracking-tight">Delivery Wajib Cashless</span>
                        </div>

                        <div class="space-y-6">
                            {{-- E-WALLET & QRIS --}}
                            <div>
                                <p class="text-[9px] font-black text-gray-300 uppercase mb-3 tracking-widest">E-Wallet & QRIS</p>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                    {{-- QRIS --}}
                                    <label class="cursor-pointer">
                                        <input type="radio" name="payment_method" value="qris" x-model="paymentMethod" class="hidden">
                                        <div :class="paymentMethod === 'qris' ? 'border-orange-500 bg-orange-50 text-orange-600' : 'border-gray-50 text-gray-400'" class="flex flex-col items-center justify-center p-3 border-2 rounded-xl transition-all h-16">
                                            <span class="text-[10px] font-black uppercase">QRIS</span>
                                            <span class="text-[8px] font-bold opacity-60 italic text-center leading-none mt-1">Satu untuk Semua</span>
                                        </div>
                                    </label>
                                    {{-- OVO --}}
                                    <label class="cursor-pointer">
                                        <input type="radio" name="payment_method" value="ovo" x-model="paymentMethod" class="hidden">
                                        <div :class="paymentMethod === 'ovo' ? 'border-purple-600 bg-purple-50 text-purple-700' : 'border-gray-50 text-gray-400'" class="flex flex-col items-center justify-center p-3 border-2 rounded-xl transition-all h-16">
                                            <span class="text-[10px] font-black uppercase">OVO</span>
                                            <span class="text-[8px] font-bold opacity-60">E-Wallet</span>
                                        </div>
                                    </label>
                                    {{-- DANA --}}
                                    <label class="cursor-pointer">
                                        <input type="radio" name="payment_method" value="dana" x-model="paymentMethod" class="hidden">
                                        <div :class="paymentMethod === 'dana' ? 'border-blue-500 bg-blue-50 text-blue-600' : 'border-gray-50 text-gray-400'" class="flex flex-col items-center justify-center p-3 border-2 rounded-xl transition-all h-16">
                                            <span class="text-[10px] font-black uppercase">DANA</span>
                                            <span class="text-[8px] font-bold opacity-60">E-Wallet</span>
                                        </div>
                                    </label>
                                    {{-- SHOPEEPAY --}}
                                    <label class="cursor-pointer">
                                        <input type="radio" name="payment_method" value="shopeepay" x-model="paymentMethod" class="hidden">
                                        <div :class="paymentMethod === 'shopeepay' ? 'border-orange-600 bg-orange-50 text-orange-700' : 'border-gray-50 text-gray-400'" class="flex flex-col items-center justify-center p-3 border-2 rounded-xl transition-all h-16">
                                            <span class="text-[10px] font-black uppercase">ShopeePay</span>
                                            <span class="text-[8px] font-bold opacity-60">E-Wallet</span>
                                        </div>
                                    </label>
                                    {{-- LINKAJA --}}
                                    <label class="cursor-pointer">
                                        <input type="radio" name="payment_method" value="linkaja" x-model="paymentMethod" class="hidden">
                                        <div :class="paymentMethod === 'linkaja' ? 'border-red-600 bg-red-50 text-red-600' : 'border-gray-50 text-gray-400'" class="flex flex-col items-center justify-center p-3 border-2 rounded-xl transition-all h-16">
                                            <span class="text-[10px] font-black uppercase">LinkAja</span>
                                            <span class="text-[8px] font-bold opacity-60">E-Wallet</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            {{-- VIRTUAL ACCOUNT --}}
                            <div>
                                <p class="text-[9px] font-black text-gray-300 uppercase mb-3 tracking-widest">Virtual Account</p>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                    <label class="cursor-pointer">
                                        <input type="radio" name="payment_method" value="va_bca" x-model="paymentMethod" class="hidden">
                                        <div :class="paymentMethod === 'va_bca' ? 'border-blue-800 bg-blue-50 text-blue-900' : 'border-gray-50 text-gray-400'" class="flex items-center justify-between px-4 py-3 border-2 rounded-xl transition-all">
                                            <span class="text-[10px] font-black uppercase italic">BCA VA</span>
                                            <span class="text-[14px]">🏦</span>
                                        </div>
                                    </label>
                                    <label class="cursor-pointer">
                                        <input type="radio" name="payment_method" value="va_bri" x-model="paymentMethod" class="hidden">
                                        <div :class="paymentMethod === 'va_bri' ? 'border-blue-600 bg-blue-50 text-blue-700' : 'border-gray-50 text-gray-400'" class="flex items-center justify-between px-4 py-3 border-2 rounded-xl transition-all">
                                            <span class="text-[10px] font-black uppercase italic">BRIVA</span>
                                            <span class="text-[14px]">🏦</span>
                                        </div>
                                    </label>
                                    <label class="cursor-pointer">
                                        <input type="radio" name="payment_method" value="va_mandiri" x-model="paymentMethod" class="hidden">
                                        <div :class="paymentMethod === 'va_mandiri' ? 'border-yellow-600 bg-yellow-50 text-yellow-700' : 'border-gray-50 text-gray-400'" class="flex items-center justify-between px-4 py-3 border-2 rounded-xl transition-all">
                                            <span class="text-[10px] font-black uppercase italic">Mandiri</span>
                                            <span class="text-[14px]">🏦</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            {{-- OPSI LAIN (TUNAI) --}}
                            <div x-show="serviceType === 'dine-in'" x-transition>
                                <p class="text-[9px] font-black text-gray-300 uppercase mb-3 tracking-widest">Lainnya</p>
                                <label class="cursor-pointer">
                                    <input type="radio" name="payment_method" value="cash" x-model="paymentMethod" class="hidden">
                                    <div :class="paymentMethod === 'cash' ? 'border-gray-900 bg-gray-900 text-white shadow-lg' : 'border-gray-100 bg-gray-50 text-gray-400'" class="w-full flex items-center justify-between px-6 py-4 border-2 rounded-xl transition-all">
                                        <span class="text-[10px] font-black uppercase tracking-widest">Bayar Tunai Di Kasir</span>
                                        <span class="text-[18px]">💵</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN (RINGKASAN) --}}
                <aside class="w-full lg:w-[400px]">
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-xl overflow-hidden sticky top-8">
                        <div class="p-6 bg-gray-900 text-white">
                            <h3 class="text-xs font-black uppercase tracking-widest">Ringkasan Pesanan</h3>
                        </div>
                        
                        <div class="p-6">
                            {{-- LIST PRODUK --}}
                            <div class="space-y-4 mb-6 border-b border-gray-100 pb-6">
                                @foreach($cart as $id => $details)
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-sm font-black text-gray-900 uppercase tracking-tight">{{ $details['name'] }}</p>
                                        <p class="text-[10px] text-gray-400 font-bold uppercase">{{ $details['quantity'] }}x @ Rp {{ number_format($details['price'], 0, ',', '.') }}</p>
                                    </div>
                                    <p class="text-sm font-black text-gray-900">Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}</p>
                                </div>
                                @endforeach
                            </div>

                            {{-- TOTALAN --}}
                            <div class="space-y-3">
                                <div class="flex justify-between text-[11px] font-bold text-gray-400 uppercase"><span>Subtotal</span><span class="text-gray-900 font-black">Rp {{ number_format($subtotal, 0, ',', '.') }}</span></div>
                                <div class="flex justify-between text-[11px] font-bold text-gray-400 uppercase"><span>Pajak (10%)</span><span class="text-gray-900 font-black">Rp {{ number_format($tax, 0, ',', '.') }}</span></div>
                                <div class="flex justify-between text-[11px] font-bold uppercase" :class="serviceType === 'delivery' ? 'text-orange-600' : 'text-gray-300'">
                                    <span>Ongkir Antar</span>
                                    <span class="font-black" x-text="shipping === 0 ? 'GRATIS' : 'Rp 15.000'"></span>
                                </div>
                                
                                <div class="pt-4 mt-2 border-t border-gray-100 flex justify-between items-center">
                                    <span class="text-xs font-black uppercase text-gray-900">Total Bayar</span>
                                    <span class="text-2xl font-black text-orange-600 tracking-tighter" x-text="'Rp ' + (subtotal + tax + shipping).toLocaleString('id-ID')"></span>
                                </div>
                            </div>
                            <a href="{{ route('cart.index') }}" class="block w-full mt-3 py-3 text-center text-[9px] font-black uppercase tracking-widest text-gray-400 hover:text-orange-600 transition-colors border border-gray-200 hover:border-orange-300 rounded-lg hover:bg-orange-50">
                                ← Ubah Pesanan
                            </a>
                            {{-- Ubah sementara jadi tombol biasa tanpa x-show/isSubmitting --}}
                            <button type="submit" class="w-full mt-6 py-4 bg-gray-900 text-white rounded-xl font-black text-[10px] uppercase">
                                Selesaikan Pesanan Sekarang
                            </button>
                        </div>
                    </div>
                </aside>
            </div>
        </form>
        <script>
            document.querySelector('form').onsubmit = function() {
            let btn = this.querySelector('button[type="submit"]');
            btn.disabled = true;
            btn.innerText = "SEDANG MEMPROSES...";
            btn.style.backgroundColor = "#9ca3af";
        };
</script>
    </div>
</div>

<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection