<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'nama_barang', 'deskripsi', 'harga_awal', 'waktu_mulai', 'waktu_selesai', 'status'];

    // Hubungan: Barang diunggah oleh seorang User
    public function user() {
        return $this->belongsTo(User::class);
    }

    // Hubungan: Satu barang memiliki banyak penawaran, diurutkan dari yang tertinggi
    public function lelangs() {
        return $this->hasMany(Lelang::class)->orderBy('harga_penawaran', 'desc');
    }
}