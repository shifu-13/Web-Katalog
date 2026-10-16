<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin Panel' }} - UD Berkah Bangunan</title>

    <!-- Google Fonts: Plus Jakarta Sans untuk keterbacaan prima -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

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

    <!-- Alpine.js untuk interaktivitas UI (Sidebar mobile, dropdown, preview gambar) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="h-full text-slate-800 antialiased" x-data="{ sidebarOpen: false }">
    <div class="min-h-full flex flex-col lg:flex-row">

        <!-- ======================================================== -->
        <!-- SIDEBAR NAVIGASI (RESPONSIF DESKTOP & MOBILE)           -->
        <!-- ======================================================== -->

        <!-- Backdrop Mobile -->
        <div x-show="sidebarOpen" 
             x-cloak
             @click="sidebarOpen = false"
             class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-sm lg:hidden transition-opacity"></div>

        <!-- Panel Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
               class="fixed inset-y-0 left-0 z-50 w-72 bg-slate-900 text-slate-200 flex flex-col justify-between transition-transform duration-300 ease-in-out lg:static lg:translate-x-0 border-r border-slate-800 shrink-0">
            
            <div>
                <!-- Brand Header -->
                <div class="h-20 flex items-center justify-between px-6 border-b border-slate-800/80 bg-slate-950/40">
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('images/logo.jpeg') }}" 
                             alt="Logo" 
                             class="max-h-12 w-auto object-contain rounded-lg">
                        <span class="block text-xs font-semibold uppercase tracking-wider text-amber-400">Admin Panel</span>
                    </div>
                    <!-- Tombol tutup pada tampilan mobile -->
                    <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white p-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Navigasi Utama -->
                <nav class="p-4 space-y-1.5 font-medium text-sm">
                    <!-- Menu: Dashboard -->
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center px-4 py-3 rounded-xl transition duration-150 {{ request()->routeIs('admin.dashboard*') ? 'bg-amber-500 text-slate-950 font-bold shadow-md shadow-amber-500/20' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span>Dashboard</span>
                    </a>

                    <!-- Separator Sub-menu -->
                    <div class="pt-4 pb-2 px-4 text-xs font-semibold uppercase tracking-wider text-slate-400">
                        Katalog Inventaris
                    </div>

                    <!-- Menu: Kategori -->
                    <a href="{{ route('admin.kategori.index') }}" 
                       class="flex items-center px-4 py-3 rounded-xl transition duration-150 {{ request()->routeIs('admin.kategori.*') ? 'bg-amber-500 text-slate-950 font-bold shadow-md shadow-amber-500/20' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        <span>Kategori</span>
                    </a>

                    <!-- Menu: Merek -->
                    <a href="{{ route('admin.merek.index') }}" 
                       class="flex items-center px-4 py-3 rounded-xl transition duration-150 {{ request()->routeIs('admin.merek.*') ? 'bg-amber-500 text-slate-950 font-bold shadow-md shadow-amber-500/20' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        <span>Merek</span>
                    </a>

                    <!-- Menu: Produk -->
                    <a href="{{ route('admin.produk.index') }}" 
                       class="flex items-center px-4 py-3 rounded-xl transition duration-150 {{ request()->routeIs('admin.produk.*') ? 'bg-amber-500 text-slate-950 font-bold shadow-md shadow-amber-500/20' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <span>Produk Bahan</span>
                    </a>

                    <!-- Tautan ke Frontend Toko Publik -->
                    <div class="pt-4 pb-2 px-4 text-xs font-semibold uppercase tracking-wider text-slate-400">
                        Pratinjau Toko
                    </div>
                    <a href="{{ route('katalog.index') }}" target="_blank"
                       class="flex items-center px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-800 hover:text-white transition duration-150 group">
                        <svg class="w-5 h-5 mr-3 text-slate-400 group-hover:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        <span>Lihat Website Toko</span>
                    </a>
                </nav>
            </div>

            <!-- Profile & Logout Footer -->
            <div class="p-4 border-t border-slate-800/80 bg-slate-950/30">
                <div class="flex items-center justify-between mb-3 px-2">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center font-bold text-amber-400 text-sm">
                            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-sm font-semibold text-white truncate max-w-[130px]">{{ Auth::user()->name ?? 'Administrator' }}</p>
                            <p class="text-xs text-slate-400 truncate max-w-[130px]">{{ Auth::user()->email ?? 'admin@berkahbangunan.com' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Form Logout Terproteksi Token CSRF -->
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" 
                            class="w-full flex items-center justify-center space-x-2 px-3 py-2.5 rounded-lg bg-red-950/40 text-red-400 hover:bg-red-900/60 hover:text-red-200 border border-red-800/40 transition text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span>Keluar (Logout)</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- ======================================================== -->
        <!-- AREA KONTEN UTAMA                                        -->
        <!-- ======================================================== -->
        <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
            
            <!-- Top Header Bar -->
            <header class="h-20 bg-white border-b border-slate-200/80 px-4 sm:px-6 lg:px-8 flex items-center justify-between sticky top-0 z-30 shadow-sm">
                <div class="flex items-center space-x-4">
                    <!-- Hamburger button for mobile -->
                    <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <div>
                        <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">{{ $pageTitle ?? 'Panel Admin' }}</h1>
                        @if(isset($breadcrumbs))
                            <p class="text-xs text-slate-500 mt-0.5">{{ $breadcrumbs }}</p>
                        @endif
                    </div>
                </div>

                <!-- Action Button Slot / Right Controls -->
                <div class="flex items-center space-x-3">
                    {{ $headerActions ?? '' }}
                </div>
            </header>

            <!-- Main Content Container -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto">
                
                <!-- Notifikasi Flash Message: Success -->
                @if(session('success'))
                    <div x-data="{ show: true }" x-show="show" 
                         class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-start justify-between shadow-sm">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-sm font-semibold">{{ session('success') }}</span>
                        </div>
                        <button @click="show = false" class="text-emerald-500 hover:text-emerald-700 ml-4">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                @endif

                <!-- Notifikasi Flash Message: Error / Integrity Guard -->
                @if(session('error'))
                    <div x-data="{ show: true }" x-show="show" 
                         class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 flex items-start justify-between shadow-sm">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-rose-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-sm font-semibold">{{ session('error') }}</span>
                        </div>
                        <button @click="show = false" class="text-rose-500 hover:text-rose-700 ml-4">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                @endif

                <!-- Error Validasi Global (jika ada kesalahan form) -->
                @if($errors->any())
                    <div x-data="{ show: true }" x-show="show" 
                         class="mb-6 p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 shadow-sm">
                        <div class="flex items-center space-x-2 font-bold text-sm mb-2 text-amber-800">
                            <svg class="w-5 h-5 text-amber-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <span>Terdapat beberapa kesalahan input yang perlu diperbaiki:</span>
                        </div>
                        <ul class="list-disc list-inside text-xs space-y-1 text-amber-700 ml-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Slot Konten Spesifik Halaman -->
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
