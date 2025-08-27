<?php

namespace App\Http\Controllers;

use App\Models\Penjual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PenjualAuthController extends Controller
{
    /**
     * Register Penjual
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:penjuals,email',
            'password' => 'required|string|confirmed|min:6',
            'photo'    => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'ktp'      => 'required|string|max:20',
            'npwp'     => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $photoPath = $request->file('photo')->store('penjual/foto', 'public');

        $penjual = Penjual::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'photo'     => $photoPath,
            'ktp'       => $request->ktp,
            'npwp'      => $request->npwp,
            'is_online' => false, // default saat registrasi
        ]);

        return response()->json([
            'message' => 'Registrasi berhasil',
            'penjual' => $penjual,
        ], 201);
    }

    /**
     * Login Penjual
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('penjual')->attempt($credentials)) {
            $request->session()->regenerate();

            /** @var \App\Models\Penjual|null $penjual */
            $penjual = Auth::guard('penjual')->user();

            // aman update via query statis (menghindari masalah mass assignment / editor)
            if ($penjual && $penjual->id) {
                Penjual::where('id', $penjual->id)->update(['is_online' => true]);
                // ambil ulang data segar
                $penjual = Penjual::find($penjual->id);
            }

            return response()->json([
                'message' => 'Login berhasil',
                'penjual' => $penjual,
            ]);
        }

        return response()->json([
            'message' => 'Email atau password salah',
        ], 401);
    }

    /**
     * Logout Penjual
     */
   public function logout(Request $request)
{
    /** @var \App\Models\Penjual|null $penjual */
    $penjual = Auth::guard('penjual')->user();

    if ($penjual && $penjual->id) {
        Penjual::where('id', $penjual->id)->update(['is_online' => false]);
    }

    Auth::guard('penjual')->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // Kembalikan ke halaman login Penjual
    return redirect()->route('penjual.login');
}

}
