@props(['produks', 'kategoris'])

<section id="produk" class="py-16 lg:py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full flex-grow scroll-mt-16 sm:scroll-mt-20">
    
    <div class="text-center max-w-3xl mx-auto mb-12">
        <span class="text-amber-700 bg-amber-100 font-extrabold text-base px-4 py-2 rounded-full uppercase tracking-wider inline-block mb-3">
            Koleksi Toko Lengkap
        </span>
        <h2 class="text-4xl sm:text-5xl font-black text-slate-950 mb-4">
            Katalog Produk Bangunan
        </h2>
        <p class="text-xl sm:text-2xl text-slate-600 font-medium leading-relaxed">
            Silakan <strong class="text-slate-900 underline">klik pada kotak produk</strong> untuk melihat rincian harga, merek, stok, dan tombol pesan langsung via WhatsApp.
        </p>
    </div>

    <!-- Filter Kategori: Mobile Dropdown -->
  <div class="block md:hidden mb-4 w-full relative" 
     x-data="{ open: false, selected: 'Semua Kategori ({{ $produks->count() ?? 0 }})' }">
     
    <!-- Tombol Dropdown -->
    <button @click="open = !open" @click.away="open = false" type="button"
            class="w-full flex justify-between items-center p-3 rounded-full border border-gray-200 shadow-sm text-sm text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-amber-500">
        <span x-text="selected" class="truncate font-medium"></span>
        <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    <!-- Isi Dropdown (Bisa di-scroll, batas 5-6 item) -->
    <ul x-show="open" 
        x-transition
        style="display: none;"
        class="absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-2xl shadow-xl max-h-56 overflow-y-auto divide-y divide-gray-50">
        
        <!-- Pilihan: Semua Kategori -->
        <li @click="selected = 'Semua Kategori ({{ $produks->count() ?? 0 }})'; open = false; window.location.href='#produk'"
            class="px-4 py-3 text-sm text-gray-800 hover:bg-amber-50 hover:text-amber-700 cursor-pointer font-bold transition">
            Semua Kategori ({{ $produks->count() ?? 0 }})
        </li>
        
        <!-- Pilihan: Kategori Dinamis -->
        @if(isset($kategoris))
            @foreach($kategoris as $kat)
                <li @click="selected = '{{ addslashes($kat->nama) }}'; open = false; window.location.href='#produk'"
                    class="px-4 py-3 text-sm text-gray-600 hover:bg-amber-50 hover:text-amber-700 cursor-pointer transition">
                    {{ $kat->nama }}
                </li>
            @endforeach
        @endif
    </ul>
</div>

    <!-- Filter Kategori Tombol Besar (Desktop only) -->
    <div class="hidden md:flex flex-wrap items-center justify-center gap-3 mb-12">
        <button @click="selectedCategory = 'all'" 
                type="button"
                :class="selectedCategory === 'all' 
                    ? 'bg-slate-950 text-white shadow-lg ring-4 ring-slate-400' 
                    : 'bg-white text-slate-800 hover:bg-slate-100 border-2 border-slate-300'"
                class="px-6 py-3 rounded-2xl font-bold text-lg transition transform active:scale-95">
            Semua Kategori ({{ $produks->count() ?? 0 }})
        </button>
        @if(isset($kategoris))
            @foreach($kategoris as $kat)
                <button @click="selectedCategory = '{{ $kat->nama }}'" 
                        type="button"
                        :class="selectedCategory === '{{ $kat->nama }}' 
                            ? 'bg-amber-600 text-white shadow-lg ring-4 ring-amber-300' 
                            : 'bg-white text-slate-800 hover:bg-amber-50 border-2 border-slate-300'"
                        class="px-6 py-3 rounded-2xl font-bold text-lg transition transform active:scale-95">
                    {{ $kat->nama }}
                </button>
            @endforeach
        @endif
    </div>

    <!-- GRID PRODUK -->
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 md:gap-8">
        @if(isset($produks))
            @forelse($produks as $item)
                <div x-show="matchesFilter('{{ strtolower($item->nama) }}', '{{ strtolower($item->kategori->nama) }}')" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     @click="openModal({{ $item->id }})"
                     role="button"
                     tabindex="0"
                     @keydown.enter="openModal({{ $item->id }})"
                     class="group bg-white rounded-3xl overflow-hidden border-3 border-slate-200 hover:border-amber-500 shadow-md hover:shadow-2xl transition duration-200 cursor-pointer flex flex-col focus:outline-none focus:ring-4 focus:ring-amber-500">
                    
                    <!-- 1. GAMBAR PRODUK -->
                    <div class="relative aspect-square w-full bg-slate-100 overflow-hidden">
                        <img src="{{ $item->gambar_url }}" 
                             alt="{{ $item->nama }}" 
                             loading="lazy"
                             class="w-full h-full object-cover object-center group-hover:scale-105 transition duration-300">
                        
                        @if($item->is_pinned)
                            <!-- Badge Terlaris / Rekomendasi (Pin Product) -->
                            <div class="absolute top-2.5 left-2.5 z-20 flex items-center gap-1.5 bg-red-600 text-white text-[10px] md:text-xs font-black px-2.5 py-1 rounded-full shadow-md uppercase tracking-wider">
                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <span>Terlaris</span>
                            </div>
                        @endif

                        <!-- Overlay Hint yang Bersahabat untuk Orang Tua -->
                        <div class="absolute inset-0 bg-slate-950/20 group-hover:bg-slate-950/40 transition flex items-center justify-center">
                            <span class="opacity-0 group-hover:opacity-100 transition duration-200 bg-amber-500 text-slate-950 font-black text-lg px-5 py-2.5 rounded-2xl shadow-xl flex items-center gap-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Lihat Detail
                            </span>
                        </div>
                    </div>

                    <!-- KONTEN KARTU: HANYA KATEGORI DAN NAMA -->
                    <div class="p-2 md:p-6 flex flex-col flex-grow justify-between bg-white">
                        <div>
                            <!-- 2. KATEGORI.NAMA -->
                            <span class="inline-block text-amber-800 bg-amber-100 font-extrabold text-[10px] md:text-sm sm:text-base px-2 md:px-3.5 py-1 md:py-1.5 rounded-xl uppercase tracking-wider mb-2 md:mb-3">
                                {{ $item->kategori->nama }}
                            </span>

                            <!-- 3. NAMA PRODUK (Teks Besar & Kontras Tinggi) -->
                            <h3 class="text-xs md:text-xl sm:text-2xl font-extrabold text-slate-950 group-hover:text-amber-700 transition leading-snug line-clamp-2">
                                {{ $item->nama }}
                            </h3>
                        </div>

                        <!-- Petunjuk Klik Ramah Lansia -->
                        <div class="mt-3 md:mt-6 pt-2 md:pt-4 border-t-2 border-slate-100 flex items-center justify-between text-slate-500 group-hover:text-amber-600 font-bold text-[10px] md:text-base">
                            <span>Buka Informasi & Harga</span>
                            <span class="text-base md:text-2xl">➔</span>
                        </div>
                    </div>

                </div>
            @empty
                <div class="col-span-full text-center py-16 bg-white rounded-3xl border-2 border-slate-200">
                    <p class="text-2xl font-bold text-slate-700">Belum ada data produk tersedia.</p>
                </div>
            @endforelse
        @endif
    </div>

    <!-- Paginasi Halaman Katalog -->
    @if(isset($produks) && method_exists($produks, 'links') && $produks->hasPages())
        <div class="mt-12 flex justify-center">
            {{ $produks->links() }}
        </div>
    @endif

    <!-- Indikator Jika Hasil Pencarian Kosong -->
    <div x-show="totalVisible === 0" 
         x-cloak 
         class="text-center py-16 bg-white rounded-3xl border-3 border-dashed border-slate-300 max-w-2xl mx-auto my-8 p-8">
        <svg class="w-20 h-20 mx-auto text-slate-400 mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <h3 class="text-2xl sm:text-3xl font-black text-slate-900 mb-2">Barang Tidak Ditemukan</h3>
        <p class="text-xl text-slate-600 mb-6">Kami tidak menemukan bahan bangunan dengan kata kunci "<span x-text="searchQuery" class="font-bold text-amber-600"></span>".</p>
        <button @click="searchQuery = ''; selectedCategory = 'all'; triggerSearch()" 
                class="bg-amber-500 hover:bg-amber-600 text-slate-950 font-extrabold text-xl px-8 py-4 rounded-2xl shadow-md">
            Tampilkan Semua Produk
        </button>
    </div>

</section>
