<div x-data="{ 
    chatOpen: false, 
    isTyping: false,
    messages: [{ role: 'bot', text: 'Selamat siang. Saya **Concierge AI**. Ada yang bisa saya bantu terkait layanan **Cafeku**?' }], 
    userInput: '',
    
    // Fungsi Utama Logika Chat
    processInput(customText = null) {
        let text = customText || this.userInput;
        if(!text.trim()) return;
        
        const input = text.toLowerCase();
        this.messages.push({role: 'user', text: text});
        this.userInput = '';
        this.isTyping = true;
        this.scrollToBottom();
        
        setTimeout(() => {
            this.isTyping = false;
            let response = '';
            
            // Pemetaan Logika Fungsi
            if (input.includes('lokasi') || input.includes('alamat')) {
                response = '📍 **Lokasi:** Jl. Soekarno Hatta No. 1 (Dekat USM). Kami buka hingga pukul **24.00**.';
            } else if (input.includes('reservasi') || input.includes('book')) {
                response = '🪑 **Reservasi:** Hubungi WhatsApp kami di `0812-3456-7890`. Disarankan booking H-1.';
            } else if (input.includes('kopi')) {
                response = '☕ **Coffee:** Rekomendasi kami adalah *Gula Aren Latte* dan *Caramel Macchiato*.';
            } else if (input.includes('makan')) {
                response = '🍝 **Meals:** Favorit tamu kami adalah *Rice Bowl Teriyaki* dan *Spaghetti Carbonara*.';
            } else if (input.includes('bayar') || input.includes('metode')) {
                response = '💳 **Payment:** Kami menerima QRIS, Tunai, dan Kartu Debit.';
            } else if (input.includes('order') || input.includes('beli')) {
                response = '🛒 **Order:** Tambahkan menu ke keranjang, lalu selesaikan pembayaran di ikon tas Navbar.';
            } else {
                response = 'Mohon maaf, saya belum memahami permintaan itu. Silakan pilih menu bantuan di bawah.';
            }

            this.messages.push({role: 'bot', text: response});
            this.scrollToBottom();
        }, 800);
    },
    
    scrollToBottom() {
        $nextTick(() => { 
            if(this.$refs.chatContainer) {
                this.$refs.chatContainer.scrollTo({ top: this.$refs.chatContainer.scrollHeight, behavior: 'smooth' });
            }
        });
    }
 }" 
 class="fixed bottom-8 right-8 z-[9999] font-sans antialiased">
    
    <div x-show="chatOpen" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-8"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="absolute bottom-20 right-0 w-[300px] h-[480px] bg-white shadow-[0_25px_70px_-15px_rgba(0,0,0,0.2)] rounded-[2rem] flex flex-col overflow-hidden border border-neutral-100">
        
        <div class="p-6 pb-4 flex items-center justify-between bg-white border-b border-neutral-50">
            <div class="flex items-center gap-2.5">
                <div class="w-2 h-2 bg-black rounded-full shadow-[0_0_8px_rgba(0,0,0,0.4)]"></div>
                <h3 class="text-[11px] font-black uppercase tracking-[.25em] text-neutral-900">AI Concierge</h3>
            </div>
            <button @click="chatOpen = false" class="text-neutral-400 hover:text-black transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <div x-ref="chatContainer" class="flex-1 overflow-y-auto px-6 py-4 space-y-6 scrollbar-hide bg-white">
            <template x-for="(msg, index) in messages" :key="index">
                <div class="flex flex-col" :class="msg.role === 'bot' ? 'items-start' : 'items-end'">
                    <div :class="msg.role === 'bot' ? 'text-neutral-600' : 'text-black font-bold text-right'" 
                         class="text-[12px] leading-relaxed max-w-[90%]"
                         x-html="msg.text.replace(/\*\*(.*?)\*\*/g, '<span class=\'text-black font-black\'>$1</span>').replace(/`(.*?)`/g, '<code class=\'bg-neutral-100 px-1 rounded\'>$1</code>')">
                    </div>
                </div>
            </template>
            
            <div x-show="isTyping" class="flex gap-1.5 pt-2">
                <div class="w-1 h-1 bg-black rounded-full animate-bounce"></div>
                <div class="w-1 h-1 bg-black rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                <div class="w-1 h-1 bg-black rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
            </div>
        </div>

        <div class="p-5 grid grid-cols-2 gap-2 bg-neutral-50/50 border-t border-neutral-100">
            <button @click="processInput('Lokasi')" class="btn-function">📍 Lokasi</button>
            <button @click="processInput('Reservasi')" class="btn-function">🪑 Reservasi</button>
            <button @click="processInput('Kopi')" class="btn-function">☕ Kopi</button>
            <button @click="processInput('Makan')" class="btn-function">🍝 Makan</button>
            <button @click="processInput('Bayar')" class="btn-function">💳 Bayar</button>
            <button @click="processInput('Order')" class="btn-function">🛒 Order</button>
        </div>

        <div class="px-5 pb-5 bg-neutral-50/50">
            <div class="flex items-center bg-white border border-neutral-200 p-1.5 rounded-xl focus-within:border-black transition-colors shadow-sm">
                <input type="text" x-model="userInput" @keydown.enter="processInput()" placeholder="Tanyakan sesuatu..." 
                       class="flex-1 bg-transparent px-3 text-[11px] font-medium outline-none placeholder:text-neutral-300">
                <button @click="processInput()" class="w-8 h-8 bg-black text-white rounded-lg flex items-center justify-center hover:scale-105 active:scale-90 transition-transform shadow-md">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7" /></svg>
                </button>
            </div>
        </div>
    </div>

    <button @click="chatOpen = !chatOpen; if(chatOpen) scrollToBottom()" 
            class="relative w-14 h-14 bg-black rounded-2xl shadow-2xl flex items-center justify-center hover:scale-110 active:scale-95 transition-all duration-500 group overflow-hidden">
        
        <div class="relative transition-transform duration-500" :class="chatOpen ? 'rotate-180 translate-y-12' : 'rotate-0 translate-y-0'">
             <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
        </div>

        <div class="absolute transition-transform duration-500" :class="chatOpen ? 'translate-y-0' : 'translate-y-12'">
            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path d="M19 9l-7 7-7-7" />
            </svg>
        </div>

        <div x-show="!chatOpen" class="absolute top-2 right-2 w-1.5 h-1.5 bg-white rounded-full shadow-[0_0_8px_#fff] animate-pulse"></div>
    </button>
</div>

<style>
    [x-cloak] { display: none !important; }
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    
    .btn-function {
        @apply py-2.5 text-[9px] font-bold uppercase tracking-widest bg-white border border-neutral-200 rounded-xl 
               text-neutral-500 hover:border-black hover:bg-black hover:text-white 
               transition-all duration-300 shadow-sm active:scale-95;
    }
</style>