<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function showResetForm()
    {
        return view('auth.lupa-password');
    }

    public function reset(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
        ], [
            'email.exists' => 'Email tidak ditemukan.',
            'password.min' => 'Password harus minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // Cari pengguna berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        // Redirect ke login dengan pesan sukses
        return redirect()->route('login')->with('status', 'Password berhasil direset. Silakan login dengan password baru.');
    }
}