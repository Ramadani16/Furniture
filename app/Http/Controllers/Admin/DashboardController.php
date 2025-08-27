<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // ← ini wajib
use Inertia\Inertia;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Dashboard', [
            'message' => 'Selamat datang di Dashboard Admin!',
        ]);
    }
    
}

