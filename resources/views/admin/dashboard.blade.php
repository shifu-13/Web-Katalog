@extends('layouts.admin', [
    'title' => 'Dashboard Ringkasan',
    'pageTitle' => 'Dashboard Inventaris Bahan Bangunan',
    'breadcrumbs' => 'Ringkasan performa katalog, status stok produk, dan navigasi cepat'
])

@section('headerActions')
    <!-- Tombol Aksi Cepat Tambah Produk -->
    <a href="{{ route('admin.produk.create') }}" 
       class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-sm shadow-sm transition active:scale-95">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
        </svg>
        <span>+ Tambah Produk</span>
    </a>
@endsection

@section('content')
<div class="space-y-8">

    <!-- ======================================================== -->
    <!-- 1. KARTU STATISTIK METRIK UTAMA                          -->
    <!-- ======================================================== -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Total Produk -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between hover:border-slate-300 transition">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Produk</p>
                               <p class="text-3xl font-extrabold text-slate-900 mt-2">{{ number_format($totalProduk) }}</p>
                <a href="{{ route('admin.produk.index') }}" class="inline-flex items-center text-xs font-semibold text-amber-600 hover:text-amber-700 mt-2">
                    Kelola Produk &rarr;
                </a>
            </div>
            <div class="w-13 h-13 p-3 rounded-2xl bg-amber-50 text-amber-600 border border-amber-100">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
        </div>

        <!-- Total Kategori -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between hover:border-slate-300 transition">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Kategori</p>
                <p class="text-3xl font-extrabold text-slate-900 mt-2">{{ number_format($totalKategori) }}</p>
                <a href="{{ route('admin.kategori.index') }}" class="inline-flex items-center text-xs font-semibold text-amber-600 hover:text-amber-700 mt-2">
                    Kelola Kategori &rarr;
                </a>
            </div>
            <div class="w-13 h-13 p-3 rounded-2xl bg-blue-50 text-blue-600 border border-blue-100">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
        </div>

        <!-- Total Merek Pabrikan -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between hover:border-slate-300 transition">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Merek</p>
                <p class="text-3xl font-extrabold text-slate-900 mt-2">{{ number_format($totalMerek) }}</p>
                <a href="{{ route('admin.merek.index') }}" class="inline-flex items-center text-xs font-semibold text-amber-600 hover:text-amber-700 mt-2">
                    Kelola Merek &rarr;
                </a>
            </div>
            <div class="w-13 h-13 p-3 rounded-2xl bg-indigo-50 text-indigo-600 border border-indigo-100">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
            </div>
        </div>

        <!-- Stok Habis (Perlu Perhatian) -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between hover:border-slate-300 transition">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Stok Habis</p>
                <p class="text-3xl font-extrabold {{ $produkHabis > 0 ? 'text-rose-600' : 'text-slate-900' }} mt-2">
                    {{ number_format($produkHabis) }}
                </p>
                <span class="inline-block text-xs font-semibold text-slate-500 mt-2">
                    Tersedia: <strong class="text-emerald-600">{{ number_format($produkTersedia) }}</strong> item
                </span>
            </div>
            <div class="w-13 h-13 p-3 rounded-2xl {{ $produkHabis > 0 ? 'bg-rose-50 text-rose-600 border border-rose-100' : 'bg-emerald-50 text-emerald-600 border border-emerald-100' }}">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
        </div>

    </div>

    <!-- ======================================================== -->
    <!-- 2. DAFTAR PRODUK STOK HABIS (RESTOCK PRIORITY)          -->
    <!-- ======================================================== -->
    @if($daftarStokHabis->isNotEmpty())
        <div class="bg-rose-50/70 border border-rose-200/80 rounded-2xl p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-2.5">
                    <span class="flex h-3 w-3 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-rose-500"></span>
                    </span>
                    <h2 class="text-base font-bold text-rose-900">Perlu Pengadaan Ulang: Produk Habis ({{ $daftarStokHabis->count() }})</h2>
                </div>
                <a href="{{ route('admin.produk.index', ['status_stok' => 0]) }}" class="text-xs font-bold text-rose-700 hover:text-rose-900 underline">
                    Lihat Semua Stok Habis &rarr;
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($daftarStokHabis as $itemHabis)
                    <div class="bg-white p-4 rounded-xl border border-rose-100 shadow-sm flex items-center justify-between">
                        <div class="flex items-center space-x-3 overflow-hidden">
                            <img src="{{ $itemHabis->gambar_url }}" 
                                 alt="{{ $itemHabis->nama }}" 
                                 class="w-12 h-12 object-cover rounded-lg border border-slate-100 shrink-0 bg-slate-100">
                            <div class="min-w-0">
                                <p class="text-xs font-bold text-slate-800 truncate">{{ $itemHabis->nama }}</p>
                                <p class="text-[11px] text-slate-500">{{ $itemHabis->kategori->nama ?? '-' }} &bull; {{ $itemHabis->merek->nama ?? '-' }}</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.produk.edit', $itemHabis) }}" 
                           class="ml-3 px-3 py-1.5 rounded-lg bg-rose-100 hover:bg-rose-200 text-rose-800 font-bold text-xs transition shrink-0">
                            Ubah Stok
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- ======================================================== -->
    <!-- 3. TABEL 5 PRODUK TERBARU                                -->
    <!-- ======================================================== -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-slate-900">Produk Katalog Terbaru</h2>
                <p class="text-xs text-slate-500 mt-0.5">Daftar item material yang paling akhir ditambahkan atau diperbarui</p>
            </div>
            <a href="{{ route('admin.produk.index') }}" class="text-xs font-bold text-amber-600 hover:text-amber-700">
                Buka Katalog Penuh &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50/80 text-xs font-bold uppercase tracking-wider text-slate-400 border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-6">Produk</th>
                        <th class="py-3.5 px-6">Kategori & Merek</th>
                        <th class="py-3.5 px-6">Harga / Satuan</th>
                        <th class="py-3.5 px-6">Status Stok</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($produkTerbaru as $produk)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="py-4 px-6">
                                <div class="flex items-center space-x-3.5">
                                    <img src="{{ $produk->gambar_url }}" 
                                         alt="{{ $produk->nama }}" 
                                         class="w-12 h-12 object-cover rounded-xl border border-slate-100 bg-slate-100 shrink-0">
                                    <div>
                                        <div class="font-bold text-slate-900">{{ $produk->nama }}</div>
                                        <div class="text-xs text-slate-400">{{ Str::limit($produk->deskripsi, 60) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-xs">
                                <span class="font-semibold text-slate-800">{{ $produk->kategori->nama ?? '-' }}</span>
                                <span class="text-slate-400 block">{{ $produk->merek->nama ?? '-' }}</span>
                            </td>
                            <td class="py-4 px-6 text-xs font-bold text-slate-900">
                                Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                <span class="text-slate-400 font-normal block">/ {{ $produk->satuan }}</span>
                            </td>
                            <td class="py-4 px-6">
                                @if($produk->status_stok)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                                        Tersedia
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500 mr-1.5"></span>
                                        Stok Habis
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right space-x-2">
                                <a href="{{ route('admin.produk.edit', $produk) }}" 
                                   class="inline-flex items-center px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400">
                                Belum ada data produk bahan bangunan yang tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
