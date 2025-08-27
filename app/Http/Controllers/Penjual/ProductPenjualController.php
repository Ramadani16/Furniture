<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProductPenjualController extends Controller
{
    // Tampilkan semua produk
    public function index()
    {
        $products = Product::latest()->get();

        return Inertia::render('Penjual/Produk/Index', [
            'products' => $products,
        ]);
    }

    // Form tambah produk
    public function create()
    {
        return Inertia::render('Penjual/Produk/Create');
    }

    // Simpan produk baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:furniture,elektronik,bazar',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('produk', 'public');
        }

        Product::create($data);

        return redirect()->route('penjual.produk.index')
                         ->with('success', 'Produk berhasil ditambahkan.');
    }

    // Form edit produk
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return Inertia::render('Penjual/Produk/Edit', [
    'produk' => $product, // ubah jadi 'produk'
]);

    }

    // Update produk
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:furniture,elektronik,bazar',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $data['image'] = $request->file('image')->store('produk', 'public');
        }

        $product->update($data);

        return redirect()->route('penjual.produk.index')
                         ->with('success', 'Produk berhasil diperbarui.');
    }

    // Hapus produk
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('penjual.produk.index')
                         ->with('success', 'Produk berhasil dihapus.');
    }

    // Ambil produk berdasarkan kategori (untuk filter atau search)
    public function getByCategory(Request $request)
    {
        $request->validate([
            'category' => 'required|in:furniture,elektronik,bazar',
        ]);

        $products = Product::where('category', $request->category)
                           ->latest()
                           ->paginate(8);

        return response()->json($products);
    }
}
