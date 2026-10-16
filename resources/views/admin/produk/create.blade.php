@extends('layouts.admin', [
    'title' => 'Tambah Produk Baru',
    'pageTitle' => 'Tambah Material Bangunan Baru',
    'breadcrumbs' => 'Lengkapi rincian produk, unggah foto, dan atur ketersediaan stok'
])

@section('content')
<div class="max-w-4xl mx-auto" x-data="{ imagePreviews: [] }">
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 sm:p-8">
        
        <!-- Formulir Tambah Produk: Wajib enctype='multipart/form-data' untuk upload file -->
        <form action="{{ route('admin.produk.store') }}" 
              method="POST" 
              enctype="multipart/form-data" 
              class="space-y-6">
            
            <!-- Proteksi CSRF Token Laravel -->
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- 1. Nama Produk -->
                <div class="md:col-span-2">
                    <label for="nama" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Nama Produk Bahan Bangunan <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           id="nama" 
                           name="nama" 
                           value="{{ old('nama') }}" 
                           required 
                           placeholder="Contoh: Semen Portland Komposit Tiga Roda 50 Kg"
                           class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('nama') ? 'border-rose-500 ring-1 ring-rose-500 bg-rose-50/20' : 'border-slate-200 focus:border-amber-500' }} text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500/20 transition">
                    @error('nama')
                        <p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 2. Kategori Material (Datalist Combobox) -->
                <div>
                    <label for="kategori_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Kategori Material <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           id="kategori_id" 
                           name="kategori_id" 
                           list="kategori_list"
                           value="{{ old('kategori_id') }}" 
                           required 
                           autocomplete="off"
                           placeholder="Pilih atau ketik kategori baru..."
                           class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('kategori_id') ? 'border-rose-500 ring-1 ring-rose-500 bg-rose-50/20' : 'border-slate-200 focus:border-amber-500' }} text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500/20 transition">
                    <datalist id="kategori_list">
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->nama }}"></option>
                        @endforeach
                    </datalist>
                    <p class="text-xs text-slate-500 mt-1">Pilih dari rekomendasi atau ketik kategori baru langsung.</p>
                    @error('kategori_id')
                        <p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 3. Merek Pabrikan (Datalist Combobox) -->
                <div>
                    <label for="merek_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Merek Pabrikan <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           id="merek_id" 
                           name="merek_id" 
                           list="merek_list"
                           value="{{ old('merek_id') }}" 
                           required 
                           autocomplete="off"
                           placeholder="Pilih atau ketik merek baru..."
                           class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('merek_id') ? 'border-rose-500 ring-1 ring-rose-500 bg-rose-50/20' : 'border-slate-200 focus:border-amber-500' }} text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500/20 transition">
                    <datalist id="merek_list">
                        @foreach($mereks as $merek)
                            <option value="{{ $merek->nama }}"></option>
                        @endforeach
                    </datalist>
                    <p class="text-xs text-slate-500 mt-1">Pilih dari rekomendasi atau ketik merek pabrikan baru.</p>
                    @error('merek_id')
                        <p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 4. Harga Nominal -->
                <div>
                    <label for="harga" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Harga (Rupiah) <span class="text-slate-400 font-normal">(Opsional)</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 font-bold text-xs">
                            Rp
                        </div>
                        <input type="number" 
                               id="harga" 
                               name="harga" 
                               min="0"
                               step="any"
                               value="{{ old('harga') }}" 
                               placeholder="Contoh: 69000"
                               class="w-full pl-11 pr-4 py-2.5 rounded-xl border {{ $errors->has('harga') ? 'border-rose-500 ring-1 ring-rose-500 bg-rose-50/20' : 'border-slate-200 focus:border-amber-500' }} text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500/20 transition">
                    </div>
                    <p class="text-xs text-slate-500 mt-1.5">Kosongkan jika harga custom/nego</p>
                    @error('harga')
                        <p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 5. Satuan Penjualan -->
                <div>
                    <label for="satuan" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Satuan Jual <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           id="satuan" 
                           name="satuan" 
                           value="{{ old('satuan', 'Zak') }}" 
                           required 
                           placeholder="Zak, Batang, Dus, Pail, Meter, Kg"
                           class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('satuan') ? 'border-rose-500 ring-1 ring-rose-500 bg-rose-50/20' : 'border-slate-200 focus:border-amber-500' }} text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500/20 transition">
                    @error('satuan')
                        <p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 6. Status Stok (Radio Button Pilihan) -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2.5">
                        Status Ketersediaan Stok <span class="text-rose-500">*</span>
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <!-- Radio: Tersedia (1) -->
                        <label class="flex items-center p-3.5 rounded-xl border cursor-pointer transition select-none hover:bg-slate-50 {{ old('status_stok', '1') == '1' ? 'border-emerald-500 bg-emerald-50/30' : 'border-slate-200' }}">
                            <input type="radio" 
                                   name="status_stok" 
                                   value="1" 
                                   @checked(old('status_stok', '1') == '1')
                                   class="w-4 h-4 text-emerald-600 focus:ring-emerald-500 border-slate-300">
                            <div class="ml-3">
                                <span class="block text-sm font-bold text-slate-800">Tersedia (Ready Stock)</span>
                                <span class="block text-xs text-slate-500">Produk siap dijual dan tampil di katalog utama</span>
                            </div>
                        </label>

                        <!-- Radio: Stok Habis (0) -->
                        <label class="flex items-center p-3.5 rounded-xl border cursor-pointer transition select-none hover:bg-slate-50 {{ old('status_stok') === '0' ? 'border-rose-500 bg-rose-50/30' : 'border-slate-200' }}">
                            <input type="radio" 
                                   name="status_stok" 
                                   value="0" 
                                   @checked(old('status_stok') === '0')
                                   class="w-4 h-4 text-rose-600 focus:ring-rose-500 border-slate-300">
                            <div class="ml-3">
                                <span class="block text-sm font-bold text-slate-800">Habis (Out of Stock)</span>
                                <span class="block text-xs text-slate-500">Ditandai badge stok habis pada katalog publik</span>
                            </div>
                        </label>
                    </div>
                    @error('status_stok')
                        <p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 7. Deskripsi Spesifikasi Bahan -->
                <div class="md:col-span-2">
                    <label for="deskripsi" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Deskripsi & Spesifikasi Produk <span class="text-rose-500">*</span>
                    </label>
                    <textarea id="deskripsi" 
                              name="deskripsi" 
                              rows="4" 
                              required 
                              placeholder="Rincian ukuran dimensi, komposisi bahan, standar SNI, atau petunjuk pemakaian..."
                              class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('deskripsi') ? 'border-rose-500 ring-1 ring-rose-500 bg-rose-50/20' : 'border-slate-200 focus:border-amber-500' }} text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-500/20 transition">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="text-xs text-rose-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 8. Upload Foto Produk & Pratinjau Aman (Maksimal 10 Foto) -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Unggah Foto Produk (Maksimal 10 Foto) <span class="text-rose-500">*</span>
                    </label>
                    
                    <div class="p-4 rounded-xl border border-dashed border-slate-300 bg-slate-50/50 space-y-4">
                        <!-- Kotak Pratinjau Gambar Multi -->
                        <div class="flex flex-wrap items-center gap-3">
                            <template x-for="(preview, index) in imagePreviews" :key="index">
                                <div class="w-20 h-20 rounded-xl border border-slate-200 bg-white overflow-hidden shadow-sm relative group">
                                    <img :src="preview" class="w-full h-full object-cover">
                                    <span class="absolute bottom-1 right-1 bg-slate-900/80 text-white text-[10px] px-1.5 py-0.5 rounded-md font-bold" x-text="index + 1"></span>
                                </div>
                            </template>
                            <template x-if="imagePreviews.length === 0">
                                <div class="w-24 h-24 rounded-xl border border-slate-200 bg-white overflow-hidden flex items-center justify-center shrink-0 shadow-sm">
                                    <div class="text-center p-2">
                                        <svg class="mx-auto w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="text-[10px] text-slate-400 font-semibold block mt-1">Pratinjau Foto</span>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Kontrol File Input Multiple -->
                        <div>
                            <input type="file" 
                                   id="gambar" 
                                   name="gambar[]" 
                                   multiple
                                   required
                                   accept=".jpg,.jpeg,.png,.webp"
                                   @change="
                                       imagePreviews = [];
                                       const files = Array.from($event.target.files).slice(0, 10);
                                       files.forEach(file => {
                                           const reader = new FileReader();
                                           reader.onload = (e) => imagePreviews.push(e.target.result);
                                           reader.readAsDataURL(file);
                                       });
                                   "
                                   class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-amber-500 file:text-slate-950 hover:file:bg-amber-400 file:cursor-pointer">
                            <p class="text-xs text-slate-500 mt-2">
                                Dapat memilih hingga <strong>10 foto sekaligus</strong>. Format: <strong>JPG, JPEG, PNG, WEBP</strong> (Maks: 2 MB per foto).
                            </p>
                        </div>
                    </div>

                    @error('gambar')
                        <p class="text-xs text-rose-500 mt-1.5 flex items-center space-x-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                    @error('gambar.*')
                        <p class="text-xs text-rose-500 mt-1.5 flex items-center space-x-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

            </div>

            <!-- Tombol Simpan & Batal -->
            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-slate-100">
                <a href="{{ route('admin.produk.index') }}" 
                   class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-sm font-semibold transition">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-sm shadow-sm transition active:scale-95">
                    Simpan Produk
                </button>
            </div>
        </form>

    </div>
</div>
@endsection
