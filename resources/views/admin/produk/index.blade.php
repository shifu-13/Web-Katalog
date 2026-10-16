@extends('layouts.admin', [
    'title' => 'Manajemen Produk',
    'pageTitle' => 'Katalog Produk & Material Bangunan',
    'breadcrumbs' => 'Inventaris fisik material, penetapan harga, foto, dan status ketersediaan stok'
])

@section('content')
<div class="space-y-6">

    <!-- Area Tombol Aksi -->
    <div class="flex justify-end">
        <a href="{{ route('admin.produk.create') }}" 
           class="inline-flex items-center space-x-2 px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-900 font-bold text-sm shadow-md transition-all active:scale-95">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            <span>Tambah Produk Baru</span>
        </a>
    </div>

    <!-- Filter & Pencarian Dinamis (Kode lama tetap di bawah sini) -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        <form action="{{ route('admin.produk.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3.5 items-end">
            <!-- ... sisa kode filter form ... -->

            <!-- Pencarian Teks -->
            <div class="lg:col-span-2">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Cari Produk</label>
                <div class="relative">
                    <input type="text" 
                           name="q" 
                           value="{{ $search ?? '' }}" 
                           placeholder="Nama bahan bangunan, spesifikasi..."
                           class="w-full pl-10 pr-4 py-2 rounded-xl bg-slate-50 border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 transition">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Dropdown Filter Kategori -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Kategori</label>
                <select name="kategori_id" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 transition">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $k)
                        <option value="{{ $k->id }}" @selected(request('kategori_id') == $k->id)>{{ $k->nama }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Dropdown Filter Merek -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Merek</label>
                <select name="merek_id" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 transition">
                    <option value="">Semua Merek</option>
                    @foreach($mereks as $m)
                        <option value="{{ $m->id }}" @selected(request('merek_id') == $m->id)>{{ $m->nama }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Dropdown Filter Status Stok & Tombol Terapkan -->
            <div class="flex items-center space-x-2">
                <div class="flex-1">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1.5">Status</label>
                    <select name="status_stok" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 transition">
                        <option value="">Semua Status</option>
                        <option value="1" @selected(request('status_stok') === '1')>Tersedia</option>
                        <option value="0" @selected(request('status_stok') === '0')>Stok Habis</option>
                    </select>
                </div>
                <button type="submit" class="mt-5 px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm transition">
                    Filter
                </button>
                @if(request()->hasAny(['q', 'kategori_id', 'merek_id', 'status_stok']))
                    <a href="{{ route('admin.produk.index') }}" 
                       class="mt-5 p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 transition" 
                       title="Reset Filter">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </a>
                @endif
            </div>

        </form>
    </div>

    <!-- Tabel Data Produk -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50/80 text-xs font-bold uppercase tracking-wider text-slate-400 border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-6">Foto & Nama Produk</th>
                        <th class="py-3.5 px-6">Kategori</th>
                        <th class="py-3.5 px-6">Merek</th>
                        <th class="py-3.5 px-6">Harga & Satuan</th>
                        <th class="py-3.5 px-6">Status Stok</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($produks as $produk)
                        <tr class="hover:bg-slate-50/60 transition">
                            <!-- Foto & Nama Produk -->
                            <td class="py-4 px-6">
                                <div class="flex items-center space-x-3.5">
                                    <img src="{{ $produk->gambar_url }}" 
                                         alt="{{ $produk->nama }}" 
                                         class="w-14 h-14 object-cover rounded-xl border border-slate-100 bg-slate-100 shrink-0 shadow-sm">
                                    <div class="min-w-0 max-w-xs">
                                        <p class="font-bold text-slate-900 truncate">{{ $produk->nama }}</p>
                                        <p class="text-xs text-slate-400 mt-0.5 line-clamp-1">{{ $produk->deskripsi }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Kategori -->
                            <td class="py-4 px-6 text-xs font-semibold text-slate-800">
                                <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700">
                                    {{ $produk->kategori->nama ?? '-' }}
                                </span>
                            </td>

                            <!-- Merek -->
                            <td class="py-4 px-6 text-xs font-semibold text-slate-800">
                                {{ $produk->merek->nama ?? '-' }}
                            </td>

                            <!-- Harga & Satuan -->
                            <td class="py-4 px-6 text-xs">
                                <span class="font-extrabold text-slate-900 block text-sm">
                                    @if($produk->harga !== null && (float) $produk->harga > 0)
                                        Rp {{ number_format((float) $produk->harga, 0, ',', '.') }}
                                    @else
                                        <span class="text-amber-700 italic">Harga Custom / Nego</span>
                                    @endif
                                </span>
                                <span class="text-slate-400">per {{ $produk->satuan }}</span>
                            </td>

                            <!-- Status Stok: Radio/Badge Indikator -->
                            <td class="py-4 px-6">
                                @if($produk->status_stok)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                                        Tersedia
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500 mr-1.5"></span>
                                        Habis
                                    </span>
                                @endif
                            </td>

                            <!-- Aksi Edit & Hapus -->
                            <td class="py-4 px-6 text-right">
                                <div class="inline-flex items-center space-x-2">
                                    <!-- Toggle Pin/Unpin Produk -->
                                    <form action="{{ route('admin.produk.toggle-pin', $produk) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="p-2 rounded-lg transition {{ $produk->is_pinned ? 'bg-amber-500 text-white hover:bg-amber-600 shadow-sm' : 'text-slate-400 hover:text-amber-600 hover:bg-amber-50' }}"
                                                title="{{ $produk->is_pinned ? 'Lepas Sematan (Unpin)' : 'Sematkan ke Posisi Teratas (Pin)' }}">
                                            @if($produk->is_pinned)
                                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                                    <path d="M16 3H8a1 1 0 00-1 1v2.5a3 3 0 01-1.5 2.6L4.2 10.3A1 1 0 005 12h6v8a1 1 0 102 0v-8h6a1 1 0 00.8-1.7l-1.3-1.2A3 3 0 0117 6.5V4a1 1 0 00-1-1z"/>
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 3H8a1 1 0 00-1 1v2.5a3 3 0 01-1.5 2.6L4.2 10.3A1 1 0 005 12h6v8a1 1 0 102 0v-8h6a1 1 0 00.8-1.7l-1.3-1.2A3 3 0 0117 6.5V4a1 1 0 00-1-1z"/>
                                                </svg>
                                            @endif
                                        </button>
                                    </form>

                                    <a href="{{ route('admin.produk.edit', $produk) }}" 
                                       class="p-2 rounded-lg text-slate-500 hover:text-amber-600 hover:bg-amber-50 transition"
                                       title="Edit Produk">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>

                                    <!-- Form Hapus dengan Proteksi CSRF & Hapus File Gambar Aman di Controller -->
                                    <form action="{{ route('admin.produk.destroy', $produk) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk \'{{ addslashes($produk->nama) }}\'?');" 
                                          class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-2 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 transition"
                                                title="Hapus Produk">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <p class="font-medium">Tidak ada produk yang cocok dengan parameter filter.</p>
                                <a href="{{ route('admin.produk.create') }}" class="inline-block mt-2 text-xs font-bold text-amber-600 hover:text-amber-700">
                                    + Tambah Produk Baru Sekarang
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($produks->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $produks->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
