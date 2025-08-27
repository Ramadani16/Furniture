<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penjual;
use Inertia\Inertia;

class PenjualAdminController extends Controller
{
    public function index()
    {
        $penjuals = Penjual::latest()->get();

        return Inertia::render('Admin/Penjual/Index', [
            'penjuals' => $penjuals
        ]);
    }
}
