<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class CustomerPenjualController extends Controller
{
    public function index()
    {
        $customers = User::select('id', 'name', 'email', 'created_at')->get();

        return Inertia::render('Penjual/customer/index', [
            'customers' => $customers,
        ]);
    }

    public function create()
    {
        return Inertia::render('Penjual/customer/create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('penjual.customer.index')->with('success', 'Customer berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $customer = User::findOrFail($id);
        return Inertia::render('Penjual/customer/edit', [
            'customer' => $customer,
        ]);
    }

    public function update(Request $request, $id)
    {
        $customer = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
        ]);

        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $customer->password,
        ]);

        return redirect()->route('penjual.customers.index')->with('success', 'Customer berhasil diupdate.');
    }

    public function destroy($id)
    {
        $customer = User::findOrFail($id);
        $customer->delete();

        return redirect()->route('penjual.customers.index')->with('success', 'Customer berhasil dihapus.');
    }
}
