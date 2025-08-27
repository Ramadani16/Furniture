<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;

class LogAktivitasController extends Controller
{
    public function index()
    {
        $logs = LogAktivitas::with('user')
            ->latest()
            ->get();

        return inertia('Admin/LogAktivitas/Index', [
            'logs' => $logs
        ]);
    }
}

