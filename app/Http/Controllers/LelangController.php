<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Lelang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LelangController extends Controller
{
    /**
     * Menyimpan data penawaran (bid) baru dari user
     */
    public function store(Request $request, Barang $barang)
    {
        // 1. Ambil harga tertinggi saat ini, jika belum ada tawaran maka pakai harga awal barang
        $hargaTertinggi = $barang->lelangs->max('harga_penawaran') ?? $barang->harga_awal;

        // 2. Validasi input: nominal tawaran wajib lebih tinggi dari harga saat ini
        $request->validate([
            'harga_penawaran' => 'required|numeric|gt:' . $hargaTertinggi,
        ], [
            'harga_penawaran.required' => 'Nominal penawaran tidak boleh kosong!',
            'harga_penawaran.numeric'  => 'Nominal penawaran harus berupa angka!',
            'harga_penawaran.gt'       => 'Nominal penawaran harus lebih tinggi dari harga penawaran tertinggi saat ini!',
        ]);

        // 3. Simpan data penawaran baru ke tabel lelangs
        Lelang::create([
            'barang_id'       => $barang->id,
            'user_id'         => Auth::id(), // ID user yang sedang login
            'harga_penawaran' => $request->harga_penawaran,
        ]);

        // 4. Kembali ke halaman detail barang dengan pesan sukses
        return redirect()->back()->with('success', 'Penawaran Anda berhasil diajukan!');
    }
}