<div x-data="loadingHandler" 
     x-show="shouldShow && !loaded"
     x-transition:leave="transition ease-in-out duration-1000"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-110"
     class="fixed inset-0 z-[10000] flex items-center justify-center bg-neutral-950 overflow-hidden"
     x-cloak>
    <style>[x-cloak] { display: none !important; }</style>
    
    <div class="absolute inset-0 opacity-20">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-orange-900/30 rounded-full blur-[120px] animate-pulse"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-orange-900/20 rounded-full blur-[120px] animate-pulse" style="animation-delay: 1s"></div>
    </div>

    <div class="relative flex flex-col items-center">
        <div class="overflow-hidden mb-4">
            <h1 x-show="textShow"
                x-transition:enter="transition transform duration-[1200ms] ease-out"
                x-transition:enter-start="translate-y-full italic opacity-0"
                x-transition:enter-end="translate-y-0 italic opacity-100"
                class="text-4xl md:text-5xl font-black tracking-tighter text-white uppercase italic">
                CAFE<span class="text-orange-500 not-italic">KU.</span>
            </h1>
        </div>
        </div>
</div>