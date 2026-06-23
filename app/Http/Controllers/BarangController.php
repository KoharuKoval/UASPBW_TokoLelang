<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Lelang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarangController extends Controller
{
    // Menampilkan semua barang lelang di Dashboard
    public function index()
    {
        $barangs = Barang::with('lelangs')->latest()->get();
        return view('dashboard', compact('barangs'));
    }

    // Menampilkan form tambah barang
    public function create()
    {
        return view('barang.create');
    }

    // Menyimpan data barang lelang baru dengan validasi ketat
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga_awal' => 'required|numeric|min:1000',
            'waktu_mulai' => 'required|date|after_or_equal:now',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
        ]);

        Barang::create([
            'user_id' => Auth::id(),
            'nama_barang' => $request->nama_barang,
            'deskripsi' => $request->deskripsi,
            'harga_awal' => $request->harga_awal,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
        ]);

        return redirect()->route('dashboard')->with('success', 'Barang lelang berhasil ditambahkan!');
    }

    // Menampilkan detail barang, timer, dan riwayat bid
    public function show(Barang $barang)
    {
        $barang->load('lelangs.user');
        $tawaran_tertinggi = $barang->lelangs->first()?->harga_penawaran ?? $barang->harga_awal;
        return view('barang.show', compact('barang', 'tawaran_tertinggi'));
    }

    // Menampilkan halaman form edit
    public function edit(Barang $barang)
    {
        if ($barang->user_id !== Auth::id()) {
            abort(403, 'Anda bukan pemilik barang ini.');
        }
        return view('barang.edit', compact('barang'));
    }

    // Memperbarui informasi barang lelang
    public function update(Request $request, Barang $barang)
    {
        if ($barang->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        $barang->update($request->only('nama_barang', 'deskripsi'));

        return redirect()->route('barang.show', $barang->id)->with('success', 'Informasi barang berhasil diperbarui!');
    }

    // Menghapus barang lelang
    public function destroy(Barang $barang)
    {
        if ($barang->user_id !== Auth::id()) {
            abort(403);
        }

        $barang->delete();
        return redirect()->route('dashboard')->with('success', 'Barang lelang berhasil dihapus.');
    }

    // Memproses ajuan penawaran (Bid) dengan validasi waktu & harga
    public function tawar(Request $request, Barang $barang)
    {
        // 1. PENGAMATAN BACKEND: Validasi durasi waktu lelang
        if (now()->gt($barang->waktu_selesai)) {
            return redirect()->back()->with('error', 'Maaf, waktu lelang untuk barang ini sudah ditutup!');
        }
        
        if (now()->lt($barang->waktu_mulai)) {
            return redirect()->back()->with('error', 'Lelang untuk barang ini belum dimulai.');
        }

        $tawaran_tertinggi = $barang->lelangs->first()?->harga_penawaran ?? $barang->harga_awal;

        // 2. Validasi nominal penawaran harus lebih tinggi dari saat ini
        $request->validate([
            'harga_penawaran' => 'required|numeric|gt:' . $tawaran_tertinggi,
        ], [
            'harga_penawaran.gt' => 'Tawaran Anda harus lebih tinggi dari harga tertinggi saat ini (Rp ' . number_format($tawaran_tertinggi) . ').'
        ]);

        Lelang::create([
            'barang_id' => $barang->id,
            'user_id' => Auth::id(),
            'harga_penawaran' => $request->harga_penawaran
        ]);

        return redirect()->back()->with('success', 'Tawaran Anda berhasil dikirim!');
    }
}