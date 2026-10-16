<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrator - UD Berkah Bangunan</title>
    
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
                    }
                }
            }
        }
    </script>
</head>
<body class="h-full flex items-center justify-center p-4 bg-slate-950 font-sans antialiased selection:bg-amber-500 selection:text-slate-950">

    <div class="w-full max-w-md">
        <!-- Logo & Identitas Brand -->
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo.jpeg') }}" 
                 alt="Logo" 
                 class="h-16 w-auto mx-auto object-contain rounded-2xl shadow-xl shadow-amber-500/10 mb-4">
            <p class="text-sm text-slate-400 mt-1">Masuk ke Portal Pengelolaan Katalog Bahan Bangunan</p>
        </div>

        <!-- Kartu Formulir Login -->
        <div class="bg-slate-900 border border-slate-800 rounded-3xl p-8 shadow-2xl backdrop-blur-xl">
            
            <!-- Notifikasi Pesan Flash Status/Error -->
            @if(session('success'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-950/60 border border-emerald-800/80 text-emerald-300 text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 rounded-xl bg-rose-950/60 border border-rose-800/80 text-rose-300 text-sm font-medium">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Form Otentikasi Admin -->
            <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Input Email -->
                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                        Alamat Email Admin
                    </label>
                    <div class="relative">
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               autofocus
                               placeholder="admin@berkahbangunan.com"
                               class="w-full px-4 py-3 rounded-xl bg-slate-950/80 border {{ $errors->has('email') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-700/80' }} text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-amber-500 text-sm transition">
                    </div>
                    <!-- Validasi Error Blade Escaping -->
                    @error('email')
                        <p class="text-xs text-red-400 mt-1.5 flex items-center space-x-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Input Kata Sandi -->
                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                        Kata Sandi
                    </label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           required 
                           placeholder="••••••••"
                           class="w-full px-4 py-3 rounded-xl bg-slate-950/80 border {{ $errors->has('password') ? 'border-red-500 ring-1 ring-red-500' : 'border-slate-700/80' }} text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-amber-500 text-sm transition">
                    @error('password')
                        <p class="text-xs text-red-400 mt-1.5 flex items-center space-x-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Ingat Saya (Remember Me) -->
                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center space-x-2.5 text-xs text-slate-400 cursor-pointer select-none">
                        <input type="checkbox" 
                               name="remember" 
                               class="w-4 h-4 rounded border-slate-700 bg-slate-950 text-amber-500 focus:ring-amber-500 focus:ring-offset-slate-900">
                        <span>Ingat sesi saya di perangkat ini</span>
                    </label>
                </div>

                <!-- Tombol Submit -->
                <button type="submit" 
                        class="w-full py-3.5 px-4 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-sm tracking-wide shadow-lg shadow-amber-500/20 active:scale-[0.99] transition duration-150">
                    Masuk ke Dashboard
                </button>
            </form>

            <!-- Tautan Kembali ke Frontend Publik -->
            <div class="mt-6 pt-6 border-t border-slate-800 text-center">
                <a href="{{ route('katalog.index') }}" class="text-xs text-slate-400 hover:text-amber-400 transition inline-flex items-center space-x-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span>Kembali ke Halaman Publik Toko</span>
                </a>
            </div>
        </div>
        
        <!-- Info Kredensial Pengujian -->
        <p class="text-center text-xs text-slate-400 mt-6">
            Default Admin: <span class="text-slate-300 font-mono">admin@berkahbangunan.com</span> / <span class="text-slate-300 font-mono">password123</span>
        </p>
    </div>

</body>
</html>
