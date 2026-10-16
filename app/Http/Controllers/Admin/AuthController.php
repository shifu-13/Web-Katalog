<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Menampilkan form login admin.
     * Jika admin sudah terautentikasi, alihkan langsung ke dashboard.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    /**
     * Memproses percobaan login dengan proteksi keamanan.
     * - Memvalidasi format input & menerapkan Rate Limiting via LoginRequest.
     * - Regenerasi session ID untuk mencegah serangan Session Fixation.
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        // Jalankan autentikasi dan pengecekan rate limiting
        $request->authenticate();

        // Regenerasi ID sesi aktif untuk mencegah eksploitasi Session Fixation
        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'))
            ->with('success', 'Selamat datang kembali, ' . Auth::user()->name . '!');
    }

    /**
     * Memproses logout admin secara aman.
     * - Membersihkan guard auth.
     * - Menghancurkan session saat ini (invalidate).
     * - Menghasilkan token CSRF baru (regenerateToken) untuk mencegah replay request.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        // Batalkan sesi saat ini dan buat token CSRF baru
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda telah berhasil keluar dari sistem admin.');
    }
}
