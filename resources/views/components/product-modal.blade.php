<div x-show="isModalOpen" 
     x-cloak 
     @keydown.escape.window="closeModal()" 
     class="fixed inset-0 z-50 overflow-y-auto" 
     aria-labelledby="modal-title" 
     role="dialog" 
     aria-modal="true">
    
    <!-- Backdrop Gelap Pekat (Kontras Tinggi) -->
    <div x-show="isModalOpen"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="closeModal()" 
         class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm transition-opacity"></div>

    <div class="flex min-h-full items-center justify-center p-4 sm:p-6 text-center">
        
        <div x-show="isModalOpen"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-8 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-8 sm:scale-95"
             @click.outside="closeModal()"
             class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 w-full max-w-4xl border-4 border-slate-300">
            
            <!-- Loading State Skeleton -->
            <div x-show="isLoading" class="p-12 text-center space-y-6">
                <div class="w-16 h-16 border-4 border-amber-500 border-t-transparent rounded-full animate-spin mx-auto"></div>
                <p class="text-2xl font-black text-slate-800">Sedang Memuat Data Produk...</p>
            </div>

            <!-- Konten Detail Produk (Loaded via Fetch API) -->
            <div x-show="!isLoading && productData" class="flex flex-col md:flex-row">
                
                <!-- Gambar Penuh Produk & Carousel Thumbnail (Alpine.js) -->
                <div class="md:w-1/2 bg-slate-100 flex flex-col justify-between p-4 sm:p-6"
                     x-data="{
                        activeImageIndex: 0,
                        get images() {
                            if (!productData) return [];
                            let raw = productData.gambar;
                            if (typeof raw === 'string') {
                                try {
                                    raw = JSON.parse(raw);
                                } catch (e) {
                                    raw = [raw];
                                }
                            }
                            if (!Array.isArray(raw)) {
                                raw = raw ? [raw] : [];
                            }
                            if (raw.length === 0 && productData?.gambar_utama) {
                                raw = [productData.gambar_utama];
                            }
                            return raw.map(img => {
                                if (!img) return '/images/placeholder.png';
                                if (img.startsWith('http://') || img.startsWith('https://') || img.startsWith('/')) {
                                    return img;
                                }
                                return '/storage/' + img;
                            });
                        },
                        get currentImage() {
                            return this.images[this.activeImageIndex] || this.images[0] || '/images/placeholder.png';
                        }
                     }"
                     x-init="$watch('productData', () => { activeImageIndex = 0; })">
                    
                    <!-- Main Large Image Container -->
                    <div class="relative w-full h-[250px] md:min-h-[320px] md:aspect-square bg-slate-200 rounded-2xl overflow-hidden shadow-inner flex items-center justify-center">
                        <img :src="currentImage" 
                             :alt="productData?.nama" 
                             class="w-full h-full object-cover object-center transition-all duration-300">
                        
                        <!-- Badges Kategori & Merek di Foto -->
                        <div class="absolute top-4 left-4 flex flex-col gap-2 z-10 pointer-events-none">
                            <span x-text="productData?.kategori" 
                                  class="bg-slate-900/90 text-white font-extrabold text-xs md:text-sm sm:text-base px-2 md:px-3.5 py-1 md:py-1.5 rounded-xl shadow-lg"></span>
                            <span x-text="'Merek: ' + productData?.merek" 
                                  class="bg-amber-500 text-slate-950 font-black text-xs md:text-sm sm:text-base px-2 md:px-3.5 py-1 md:py-1.5 rounded-xl shadow-lg"></span>
                        </div>

                        <!-- Indikator Index Foto -->
                        <template x-if="images.length > 1">
                            <div class="absolute bottom-3 right-3 bg-slate-950/80 text-white text-xs font-bold px-3 py-1.5 rounded-full backdrop-blur-sm pointer-events-none shadow">
                                <span x-text="(activeImageIndex + 1) + ' / ' + images.length"></span>
                            </div>
                        </template>
                    </div>

                    <!-- Row of Clickable Thumbnails -->
                    <template x-if="images.length > 1">
                        <div class="flex items-center gap-2 mt-4 overflow-x-auto pb-2">
                            <template x-for="(img, idx) in images" :key="idx">
                                <button type="button"
                                        @click="activeImageIndex = idx"
                                        class="w-16 h-16 sm:w-20 sm:h-20 flex-shrink-0 rounded-xl overflow-hidden border-2 transition transform hover:scale-105 focus:outline-none"
                                        :class="activeImageIndex === idx ? 'border-amber-500 ring-2 ring-amber-400 ring-offset-1' : 'border-slate-300 opacity-70 hover:opacity-100'"
                                        :aria-label="'Pilih foto ' + (idx + 1)">
                                    <img :src="img" :alt="'Thumbnail ' + (idx + 1)" class="w-full h-full object-cover">
                                </button>
                            </template>
                        </div>
                    </template>
                </div>

                <!-- Informasi Rinci Produk -->
                <div class="md:w-1/2 p-4 md:p-8 flex flex-col justify-between bg-white">
                    
                    <div>
                        <!-- Header Modal & Tombol Tutup Besar -->
                        <div class="flex items-start justify-between gap-4 mb-4">
                            <div>
                                <span class="text-slate-500 font-bold text-xs md:text-base block uppercase tracking-wider">
                                    Rincian Produk
                                </span>
                                <h3 id="modal-title" 
                                    x-text="productData?.nama" 
                                    class="text-lg md:text-3xl font-black text-slate-950 leading-tight mt-1"></h3>
                            </div>
                            <button @click="closeModal()" 
                                    type="button" 
                                    class="bg-slate-100 hover:bg-slate-200 text-slate-700 hover:text-slate-900 rounded-2xl p-3 font-black text-2xl transition focus:outline-none focus:ring-4 focus:ring-amber-500 flex-shrink-0"
                                    aria-label="Tutup Jendela Modal">
                                ✕
                            </button>
                        </div>

                        <!-- Badge Status Stok (Warna Jelas) -->
                        <div class="mb-6">
                            <template x-if="productData?.status_stok">
                                <div class="inline-flex items-center gap-2.5 bg-emerald-100 text-emerald-900 border-2 border-emerald-400 font-extrabold px-3 md:px-4 py-1.5 md:py-2 rounded-2xl text-sm md:text-lg">
                                    <span class="w-3 h-3 md:w-3.5 md:h-3.5 rounded-full bg-emerald-600 animate-pulse"></span>
                                    <span>✓ Stok Tersedia di Toko</span>
                                </div>
                            </template>
                            <template x-if="!productData?.status_stok">
                                <div class="inline-flex items-center gap-2.5 bg-rose-100 text-rose-900 border-2 border-rose-400 font-extrabold px-3 md:px-4 py-1.5 md:py-2 rounded-2xl text-sm md:text-lg">
                                    <span class="w-3 h-3 md:w-3.5 md:h-3.5 rounded-full bg-rose-600"></span>
                                    <span>✕ Stok Sedang Kosong (Pre-Order)</span>
                                </div>
                            </template>
                        </div>

                        <!-- Kotak Harga IDR & Satuan -->
                        <div class="bg-amber-50 border-3 border-amber-300 rounded-2xl p-5 mb-6">
                            <span class="text-amber-900 font-bold text-base block mb-1">Harga Satuan Resmi:</span>
                            <template x-if="productData?.harga && Number(productData?.harga) > 0">
                                <div class="flex items-baseline gap-2">
                                    <span x-text="productData?.harga_formatted" class="text-2xl md:text-4xl font-black text-amber-950"></span>
                                    <span x-text="'/ ' + productData?.satuan" class="text-lg md:text-2xl font-extrabold text-amber-800"></span>
                                </div>
                            </template>
                            <template x-if="!productData?.harga || Number(productData?.harga) === 0">
                                <div class="text-lg md:text-3xl font-black text-amber-950">
                                    Harga Custom / Hubungi Admin
                                </div>
                            </template>
                            <p class="text-sm font-semibold text-slate-600 mt-2">*Harga sudah termasuk bongkar muat di toko.</p>
                        </div>

                        <!-- Deskripsi Produk -->
                        <div class="mb-8">
                            <h4 class="text-lg font-bold text-slate-900 mb-2">Penjelasan / Spesifikasi:</h4>
                            <p x-text="productData?.deskripsi" class="text-lg text-slate-700 leading-relaxed font-normal"></p>
                        </div>
                    </div>

                    <!-- CTA Pemesanan WhatsApp (Tombol Raksasa Hijau & Jelas) -->
                    <div class="space-y-3 pt-4 border-t-2 border-slate-200">
                        <a :href="'https://wa.me/6283865854453?text=' + encodeURIComponent('Halo Admin FAZZA CINTA, saya tertarik dengan produk *' + (productData?.nama || '') + '*. Apakah bisa dibantu informasi lebih lanjut mengenai ketersediaan dan harganya?')" 
                           target="_blank" 
                           rel="noopener noreferrer" 
                           class="w-full bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white font-black text-base md:text-2xl py-3 md:py-5 px-6 rounded-2xl shadow-xl hover:shadow-emerald-600/30 transition flex items-center justify-center gap-3 text-center focus:outline-none focus:ring-4 focus:ring-emerald-400">
                            <svg class="w-8 h-8 fill-current flex-shrink-0" viewBox="0 0 24 24">
                                <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.087-.179.182-.077.357.101.174.449.741.964 1.201.662.591 1.221.774 1.394.861.173.086.275.072.376-.044.101-.116.433-.506.549-.679.116-.174.231-.145.39-.087s1.011.477 1.184.564.289.13.332.203c.044.072.044.419-.1 1.009z"/>
                            </svg>
                            <span>Pesan via WhatsApp</span>
                        </a>

                        <button @click="closeModal()" 
                                type="button" 
                                class="w-full bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-lg py-3 rounded-xl transition text-center">
                            Tutup Jendela Ini
                        </button>
                    </div>

                </div>

            </div>

        </div>

    </div>
</div>
