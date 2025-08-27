<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

class ProdukObserver
{
    protected function getPenjualId()
    {
        return Auth::guard('penjual')->id();
    }

    public function created(Product $product)
    {
        if (!Auth::guard('penjual')->check()) return;

        LogAktivitas::create([
            'user_id'   => $this->getPenjualId(),
            'aksi'      => 'Tambah Produk',
            'model'     => 'Product',
            'model_id'  => $product->id,
            'perubahan' => null,
        ]);
    }

    public function updated(Product $product)
    {
        if (!Auth::guard('penjual')->check()) return;

        $changes = [];
        foreach ($product->getChanges() as $field => $newValue) {
            if ($field === 'updated_at') continue;

            $original = $product->getOriginal($field);
            if ($original !== $newValue) {
                $changes[$field] = [
                    'old' => $original,
                    'new' => $newValue,
                ];
            }
        }

        if (!empty($changes)) {
            LogAktivitas::create([
                'user_id'   => $this->getPenjualId(),
                'aksi'      => 'Edit Produk',
                'model'     => 'Product',
                'model_id'  => $product->id,
                'perubahan' => $changes,
            ]);
        }
    }

    public function deleted(Product $product)
    {
        if (!Auth::guard('penjual')->check()) return;

        LogAktivitas::create([
            'user_id'   => $this->getPenjualId(),
            'aksi'      => 'Hapus Produk',
            'model'     => 'Product',
            'model_id'  => $product->id,
            'perubahan' => null,
        ]);
    }
}
