<?php


namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller; // ← ini wajib
use Inertia\Inertia;
use Illuminate\Http\Request;

class DashboardPenjualController extends Controller
{
  public function index()
{
    $penjual = auth('penjual')->user(); // ambil penjual yang sedang login

    return Inertia::render('Penjual/Dashboard', [
        'penjual' => $penjual,
    ]);

    
}

    
}

