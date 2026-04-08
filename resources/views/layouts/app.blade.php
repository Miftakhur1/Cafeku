<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Title --}}
    <title>@yield('title', 'Cafe UMKM')</title>
    
    {{-- Favicon --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/gemini-svg.svg') }}">
    
    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    {{-- Custom Alert --}}
    <script>
        window.addEventListener('alert', event => {
            Swal.fire({
                title: 'Berhasil!',
                text: event.detail[0].message,
                icon: 'success',
                timer: 2000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        });
    </script>

    @stack('styles')
    @livewireStyles
</head>

{{-- Tambahkan x-data scrollHandler di body agar aktif di seluruh halaman --}}
<body class="bg-gray-50" 
      x-data="scrollHandler" 
      @scroll.window.debounce.150ms="saveScroll()">

    {{-- Loading --}}
    @include('partials.loading')

    {{-- Navbar --}}
    @include('partials.navbar')

    {{-- Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('partials.footer')

    @stack('scripts')
    @livewireScripts
    
    <script>
        document.addEventListener('alpine:init', () => {
            // 1. LOGIKA UNTUK MENJAGA POSISI SCROLL
            Alpine.data('scrollHandler', () => ({
                init() {
                    // Eksekusi restore saat halaman pertama kali dimuat
                    this.restoreScroll();
                    
                    // Jika kamu menggunakan Livewire wire:navigate, 
                    // dengerkan event render untuk restore posisi
                    document.addEventListener('livewire:navigated', () => {
                        this.restoreScroll();
                    });
                },
                saveScroll() {
                    // Simpan posisi berdasarkan URL path agar scroll Beranda & Katalog terpisah
                    const storageKey = 'scroll_pos_' + window.location.pathname;
                    localStorage.setItem(storageKey, window.scrollY);
                },
                restoreScroll() {
                    const storageKey = 'scroll_pos_' + window.location.pathname;
                    const pos = localStorage.getItem(storageKey);
                    if (pos) {
                        // Gunakan window.scrollTo tanpa animasi (behavior instant) agar tidak pusing
                        window.scrollTo({ top: pos, behavior: 'auto' });
                    }
                }
            }));

            // 2. LOGIKA LOADING (Data lama kamu)
            Alpine.data('loadingHandler', () => ({
                loaded: false,
                textShow: false,
                shouldShow: false,

                init() {
                    const isLoaded = sessionStorage.getItem('cafeku_loaded');
                    if (!isLoaded) {
                        this.shouldShow = true;
                        document.body.classList.add('is-loading');
                        setTimeout(() => { this.textShow = true }, 100);

                        window.addEventListener('load', () => {
                            setTimeout(() => {
                                this.loaded = true;
                                this.shouldShow = false;
                                sessionStorage.setItem('cafeku_loaded', 'true');
                                document.body.classList.remove('is-loading');
                            }, 1500);
                        });
                    } else {
                        this.loaded = true;
                        this.shouldShow = false;
                        document.body.classList.remove('is-loading');
                    }
                }
            }));
        });
    </script>
</body>
</html>