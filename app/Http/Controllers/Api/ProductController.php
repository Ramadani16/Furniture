<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function getByCategory(Request $request)
    {
        $category = $request->query('category');

        $products = Product::where('category', $category)
            ->latest()
            ->paginate(8);

        return response()->json($products);
    }
}
