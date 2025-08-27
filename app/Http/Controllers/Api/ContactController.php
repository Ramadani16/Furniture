<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input form
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        // Simpan ke database (bisa ditambahkan nanti)
        // Contact::create($validated);

        // Untuk sementara return respon sukses
        return response()->json([
            'success' => true,
            'message' => 'Pesan berhasil dikirim!',
        ]);
    }
}
