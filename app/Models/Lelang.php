<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lelang extends Model
{
    use HasFactory;

    protected $fillable = ['barang_id', 'user_id', 'harga_penawaran'];

    // Hubungan: Penawaran dilakukan oleh seorang User
    public function user() {
        return $this->belongsTo(User::class);
    }
}