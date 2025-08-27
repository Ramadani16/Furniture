<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginApiController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            $admin = Auth::guard('admin')->user();

            // Kalau pakai token (Laravel Sanctum atau Passport), kamu bisa return token
            return response()->json([
                'success' => true,
                'admin' => $admin,
                // 'token' => $admin->createToken('admin-token')->plainTextToken
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Email atau password salah!'
        ], 401);
    }
}
