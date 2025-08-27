<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        return response()->json([
            ['id' => 1, 'name' => 'Jasa Pasang Furniture'],
            ['id' => 2, 'name' => 'Jasa Pengiriman']
        ]);
    }
}
