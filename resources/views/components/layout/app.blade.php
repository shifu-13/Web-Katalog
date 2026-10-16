<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UD Berkah Bangunan - Toko Bahan Bangunan Terlengkap & Terpercaya</title>
    <meta name="description" content="Katalog bahan bangunan lengkap, kualitas terbaik, harga bersahabat dan layanan ramah untuk semua kebutuhan rumah Anda.">
    
    <!-- Google Fonts: Plus Jakarta Sans (Sangat mudah dibaca oleh mata orang tua/lansia) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#fffbeb',
                            100: '#fef3c7',
                            500: '#f59e0b',
                            600: '#d97706',
                            700: '#b45309',
                            800: '#92400e',
                            900: '#78350f',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* Base typography minimum 18px for elderly readability */
        body {
            font-size: 18px;
            color: #0f172a;
            background-color: #f8fafc;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 12px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 6px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>
<body x-data="katalogApp()" class="min-h-screen flex flex-col font-sans antialiased text-slate-900 bg-slate-50 selection:bg-amber-200">

    {{ $slot }}

    <!-- Footer -->
    <footer class="bg-slate-950 text-slate-400 py-8 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-base">
            <p class="font-bold text-slate-300">© {{ date('Y') }} UD Berkah Bangunan. Hak Cipta Dilindungi Undang-Undang.</p>
            <p class="mt-1 text-slate-500">Penyedia Bahan Bangunan Resmi & Terpercaya Sejak 1988.</p>
        </div>
    </footer>

    <!-- ========================================== -->
    <!-- ALPINE.JS COMPONENT LOGIC                  -->
    <!-- ========================================== -->
    <script>
        function katalogApp() {
            return {
                mobileMenu: false,
                searchQuery: '{{ $initialSearch ?? "" }}',
                selectedCategory: 'all',
                isModalOpen: false,
                isLoading: false,
                productData: null,
                totalVisible: {{ isset($produks) ? $produks->count() : 0 }},

                init() {
                    this.$watch('isModalOpen', value => {
                        document.body.classList.toggle('overflow-hidden', value);
                    });
                    this.updateVisibleCount();
                },

                triggerSearch() {
                    this.updateVisibleCount();
                },

                setSearch(keyword) {
                    this.searchQuery = keyword;
                    this.triggerSearch();
                    this.scrollToCatalog();
                },

                scrollToCatalog() {
                    const catalogEl = document.getElementById('produk');
                    if (catalogEl) {
                        catalogEl.scrollIntoView({ behavior: 'smooth' });
                    }
                },

                matchesFilter(nama, kategori) {
                    const matchSearch = nama.toLowerCase().includes(this.searchQuery.toLowerCase());
                    const matchCategory = this.selectedCategory === 'all' || kategori.toLowerCase() === this.selectedCategory.toLowerCase();
                    return matchSearch && matchCategory;
                },

                updateVisibleCount() {
                    setTimeout(() => {
                        const items = document.querySelectorAll('[x-show*="matchesFilter"]');
                        let count = 0;
                        items.forEach(el => {
                            if (window.getComputedStyle(el).display !== 'none') {
                                count++;
                            }
                        });
                        this.totalVisible = count;
                    }, 50);
                },

                async openModal(id) {
                    this.isModalOpen = true;
                    this.isLoading = true;
                    this.productData = null;

                    try {
                        const response = await fetch(`/api/produk/${id}`);
                        this.productData = await response.json();
                    } catch (error) {
                        console.error('Error fetching product data:', error);
                    } finally {
                        this.isLoading = false;
                    }
                },

                closeModal() {
                    this.isModalOpen = false;
                    setTimeout(() => {
                        this.productData = null;
                    }, 300);
                }
            }
        }
    </script>
</body>
</html>
