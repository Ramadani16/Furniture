<?php

// app/Http/Controllers/Admin/ProductController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class ProductAdminController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        return Inertia::render('Admin/Produk/Index', [
            'products' => $products,
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Produk/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'category' => 'required|in:furniture,elektronik,bazar',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('produk', 'public');
        }

        Product::create($data);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return Inertia::render('Admin/Produk/Edit', [
            'produk' => $product,
        ]);
    }

    public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);

    $data = $request->validate([
        'name' => 'required|string',
        'category' => 'required|in:furniture,elektronik,bazar',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'image' => 'nullable|image|max:2048',
    ]);

    if ($request->hasFile('image')) {
        // hapus foto lama
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $data['image'] = $request->file('image')->store('produk', 'public');
    } else {
        // pastikan gambar lama tetap dipakai
        $data['image'] = $product->image;
    }

    $product->update($data);

    return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diperbarui.');
}


    // Tambahkan method ini ke controller yang sudah ada
public function getByCategory(Request $request)
{
    $category = $request->category;
    $products = Product::where('category', $category)
        ->latest()
        ->paginate(8);

    return response()->json($products);
}



}
