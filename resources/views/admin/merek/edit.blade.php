@extends('layouts.admin', [
    'title' => 'Edit Merek',
    'pageTitle' => 'Ubah Merek Bahan Bangunan',
    'breadcrumbs' => 'Perbarui nama merek terdaftar'
])

@section('content')
<div class="max-w-xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 sm:p-8">
        
        <!-- Form Update Merek dengan Spoofing Method PUT dan Token CSRF -->
        <form action="{{ route('admin.merek.update', $merek) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="nama" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                    Nama Merek <span class="text-rose-500">*</span>
                </label>
                <input type="text" 
                       id="nama" 
                       name="nama" 
                       value="{{ old('nama', $merek->nama) }}" 
                       required 
                       autofocus
                       class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('nama') ? 'border-rose-500 ring-1 ring-rose-500 bg-rose-50/20' : 'border-slate-200 focus:border-amber-500' }} text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500/20 transition">
                
                @error('nama')
                    <p class="text-xs text-rose-500 mt-1.5 flex items-center space-x-1">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <!-- Tombol Aksi -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.merek.index') }}" 
                   class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-sm font-semibold transition">
                    Batal
                </a>
                <button type="submit" 
                        class="px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-sm shadow-sm transition active:scale-95">
                    Perbarui Merek
                </button>
            </div>
        </form>

    </div>
</div>
@endsection
