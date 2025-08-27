<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    protected $table = 'log_aktivitas';
    protected $fillable = [
        'user_id', 'aksi', 'model', 'model_id', 'perubahan'
    ];

    protected $casts = [
        'perubahan' => 'array', // biar otomatis decode JSON
    ];

    public function user()
    {
        return $this->belongsTo(Penjual::class, 'user_id');
    }
}

