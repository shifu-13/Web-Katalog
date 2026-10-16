@extends('layouts.admin', [
    'title' => 'Manajemen Merek',
    'pageTitle' => 'Merek Pabrikan Material',
    'breadcrumbs' => 'Daftar produsen resmi (Semen Tiga Roda, Krakatau Steel, Avian, Toto, dll.)'
])

@section('headerActions')
    <a href="{{ route('admin.merek.create') }}" 
       class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-sm shadow-sm transition active:scale-95">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
        </svg>
        <span>+ Tambah Merek</span>
    </a>
@endsection

@section('content')
<div class="space-y-6">

    <!-- Filter & Pencarian Merek -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
        <form action="{{ route('admin.merek.index') }}" method="GET" class="w-full sm:w-80 relative">
            <input type="text" 
                   name="q" 
                   value="{{ $search ?? '' }}" 
                   placeholder="Cari nama merek..."
                   class="w-full pl-10 pr-4 py-2 rounded-xl bg-slate-50 border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 transition">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
        </form>

        <span class="text-xs text-slate-500">
            Total terdaftar: <strong class="text-slate-800">{{ $mereks->total() }}</strong> merek
        </span>
    </div>

    <!-- Tabel Daftar Merek -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50/80 text-xs font-bold uppercase tracking-wider text-slate-400 border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-6 w-16">#</th>
                        <th class="py-3.5 px-6">Nama Merek</th>
                        <th class="py-3.5 px-6">Produk Terkait</th>
                        <th class="py-3.5 px-6">Tanggal Dibuat</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($mereks as $index => $item)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="py-4 px-6 text-xs text-slate-400">
                                {{ $mereks->firstItem() + $index }}
                            </td>
                            <td class="py-4 px-6 font-bold text-slate-900">
                                <!-- Escaping Blade untuk proteksi XSS -->
                                {{ $item->nama }}
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">
                                    {{ $item->produks_count }} Produk
                                </span>
                            </td>
                            <td class="py-4 px-6 text-xs text-slate-400">
                                {{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="inline-flex items-center space-x-2">
                                    <a href="{{ route('admin.merek.edit', $item) }}" 
                                       class="p-2 rounded-lg text-slate-500 hover:text-amber-600 hover:bg-amber-50 transition"
                                       title="Edit Merek">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>

                                    <!-- Form Hapus dengan Proteksi CSRF -->
                                    <form action="{{ route('admin.merek.destroy', $item) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus merek \'{{ addslashes($item->nama) }}\'?');" 
                                          class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-2 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 transition"
                                                title="Hapus Merek">
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
                            <td colspan="5" class="py-10 text-center text-slate-400">
                                Tidak ada data merek yang sesuai dengan kriteria pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($mereks->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $mereks->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
