<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductPageController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->query('kategori');

        $products = Product::when($kategori, fn($query) =>
            $query->where('category', $kategori)
        )
        ->latest()
        ->paginate(8);
        
        return Inertia::render('Produk/Index', [
            'kategori' => $kategori,
            'products' => $products
        ]);
    }
}
