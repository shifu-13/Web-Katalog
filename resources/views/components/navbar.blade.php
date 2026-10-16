<header class="sticky top-0 z-40 bg-white border-b-4 border-amber-300 shadow-md">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            
            <!-- Logo & Toko Info -->
            <a href="#beranda" class="flex items-center gap-3 group focus:outline-none focus:ring-4 focus:ring-amber-500 rounded-xl p-1">
                <img src="{{ asset('images/logo.jpeg') }}" 
                     alt="Logo" 
                     class="h-12 w-auto object-contain rounded-xl shadow-sm">

                <span class="text-4xl leading-none font-black text-amber-500 tracking-tighter uppercase hidden sm:block pt-1">
        FAZZA CINTA
    </span>
            </a>

            <!-- Desktop Navigation Links (Tombol Besar & Kontras Tinggi) -->
            <nav class="hidden md:flex items-center gap-3">
                <a href="#beranda" 
                   class="px-5 py-3 rounded-xl text-lg font-bold text-slate-800 hover:text-amber-700 hover:bg-amber-50 transition border-2 border-transparent hover:border-amber-200 focus:outline-none focus:ring-4 focus:ring-amber-400">
                    Beranda
                </a>
                <a href="#produk" 
                   class="px-5 py-3 rounded-xl text-lg font-bold text-slate-800 hover:text-amber-700 hover:bg-amber-50 transition border-2 border-transparent hover:border-amber-200 focus:outline-none focus:ring-4 focus:ring-amber-400">
                    Katalog Produk
                </a>
                <a href="#tentang-kami" 
                   class="px-5 py-3 rounded-xl text-lg font-bold text-slate-800 hover:text-amber-700 hover:bg-amber-50 transition border-2 border-transparent hover:border-amber-200 focus:outline-none focus:ring-4 focus:ring-amber-400">
                    Tentang Kami
                </a>
                <a href="#kontak" 
                   class="px-5 py-3 rounded-xl text-lg font-bold text-slate-800 hover:text-amber-700 hover:bg-amber-50 transition border-2 border-transparent hover:border-amber-200 focus:outline-none focus:ring-4 focus:ring-amber-400">
                    Kontak & Toko
                </a>
            </nav>

            <!-- Tombol Cepat WhatsApp di Header -->
            <div class="flex items-center gap-3">
                <!-- Mobile Menu Button -->
                <button @click="mobileMenu = !mobileMenu" 
                        type="button"
                        class="md:hidden p-3 rounded-2xl bg-slate-100 text-slate-800 border-2 border-slate-300 hover:bg-slate-200 focus:outline-none focus:ring-4 focus:ring-amber-500"
                        aria-label="Buka Menu Navigasi">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path x-show="!mobileMenu" stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="mobileMenu" stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Drawer -->
        <div x-show="mobileMenu" 
     x-cloak
     x-transition
     @click.outside="mobileMenu = false"
     class="md:hidden absolute top-full left-0 right-0 py-4 border-t-2 border-slate-200 space-y-2 bg-white shadow-xl z-50">
    
    <!-- Beranda: Paksa scroll halus tepat ke titik paling atas (y = 0) -->
    <a @click="mobileMenu = false; window.scrollTo({top: 0, behavior: 'smooth'})" 
       href="javascript:void(0)" 
       class="block px-5 py-3.5 rounded-xl text-xl font-bold text-slate-800 hover:bg-amber-100">
        Beranda
    </a>

    <a @click="mobileMenu = false" href="#produk" class="block px-5 py-3.5 rounded-xl text-xl font-bold text-slate-800 hover:bg-amber-100">Katalog Produk</a>
    <a @click="mobileMenu = false" href="#tentang-kami" class="block px-5 py-3.5 rounded-xl text-xl font-bold text-slate-800 hover:bg-amber-100">Tentang Kami</a>
    <a @click="mobileMenu = false" href="#kontak" class="block px-5 py-3.5 rounded-xl text-xl font-bold text-slate-800 hover:bg-amber-100">Kontak & Toko</a>
</div>
    </div>
</header>
