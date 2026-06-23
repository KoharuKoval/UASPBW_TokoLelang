<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $barang->nama_barang }} - Toko Lelang</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-xl font-bold text-blue-600 tracking-wide hover:text-blue-800 transition">
                        🔨 Toko Lelang
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm font-medium text-gray-700">Halo, {{ Auth::user()->name }}</span>
                    <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900 font-semibold">Kembali ke Dashboard</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto px-4 py-10">
        
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 p-4 rounded-xl text-sm font-semibold shadow-sm">
                🎉 {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="md:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-gray-200 flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-center mb-4">
                        <h1 class="text-2xl font-black text-gray-900 tracking-tight">{{ $barang->nama_barang }}</h1>
                        @if($barang->status == 'aktif')
                            <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full font-bold uppercase">Aktif</span>
                        @else
                            <span class="bg-red-100 text-red-800 text-xs px-3 py-1 rounded-full font-bold uppercase">Ditutup</span>
                        @endif
                    </div>

                    <p class="text-gray-600 leading-relaxed text-sm whitespace-pre-line mb-6">
                        {{ $barang->deskripsi }}
                    </p>
                </div>

                <div class="border-t border-gray-100 pt-4 mt-4">
                    <div class="bg-gray-900 text-white p-4 rounded-xl flex items-center justify-between" id="timer-box" data-waktu-selesai="{{ $barang->waktu_selesai }}">
                        <div>
                            <span class="block text-xs text-gray-400 font-medium uppercase tracking-wider">Sisa Waktu Lelang:</span>
                            <span class="text-lg font-mono font-black tracking-widest id-countdown">Memuat...</span>
                        </div>
                        <span class="text-xs text-gray-500 font-medium text-right block hidden md:block">
                            Selesai: <br>{{ \Carbon\Carbon::parse($barang->waktu_selesai)->format('d M Y, H:i') }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                    <div class="mb-4">
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider block">Harga Awal</span>
                        <span class="text-xl font-bold text-gray-400">Rp{{ number_format($barang->harga_awal, 0, ',', '.') }}</span>
                    </div>

                    <div class="bg-blue-50 p-4 rounded-xl mb-6">
                        <span class="text-xs font-bold text-blue-600 uppercase tracking-wider block">Penawaran Tertinggi Saat Ini</span>
                        <span class="text-2xl font-black text-blue-900">
                            Rp{{ number_format($barang->lelangs->max('harga_penawaran') ?? $barang->harga_awal, 0, ',', '.') }}
                        </span>
                    </div>

                    @if($barang->status == 'aktif')
                        <form method="POST" action="{{ route('lelang.store', $barang->id) }}" class="space-y-3">
                            @csrf
                            <div>
                                <label for="harga_penawaran" class="block text-xs font-bold text-gray-700 mb-1 uppercase">Masukkan Penawaran Anda</label>
                                <div class="relative rounded-lg shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm font-semibold">Rp</span>
                                    </div>
                                    <input type="number" name="harga_penawaran" id="harga_penawaran" 
                                           min="{{ ($barang->lelangs->max('harga_penawaran') ?? $barang->harga_awal) + 1 }}" 
                                           required 
                                           class="w-full pl-9 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-semibold"
                                           placeholder="Lebih tinggi dari harga saat ini">
                                </div>
                                @error('harga_penawaran')
                                    <span class="text-xs text-red-600 font-semibold mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="w-full text-center bg-blue-600 text-white py-2.5 rounded-lg font-bold text-sm hover:bg-blue-700 transition shadow cursor-pointer">
                                ✋ Ajukan Penawaran
                            </button>
                        </form>
                    @else
                        <div class="text-center py-3 bg-gray-100 text-gray-500 font-bold rounded-lg text-sm">
                            Sesi Lelang Telah Berakhir
                        </div>
                    @endif
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                    <h3 class="text-sm font-bold text-gray-900 mb-3 uppercase tracking-wider">Riwayat Tawaran</h3>
                    
                    @if($barang->lelangs->isEmpty())
                        <p class="text-xs text-gray-500 text-center py-4">Belum ada penawaran masuk.</p>
                    @else
                        <div class="flow-root max-h-48 overflow-y-auto pr-1">
                            <ul class="-mb-4 space-y-3">
                                @foreach($barang->lelangs->sortByDesc('harga_penawaran') as $bid)
                                    <li class="flex justify-between items-center border-b border-gray-50 pb-2">
                                        <div>
                                            <span class="text-xs font-bold text-gray-800 block">{{ $bid->user->name }}</span>
                                            <span class="text-[10px] text-gray-400 block">{{ $bid->created_at->diffForHumans() }}</span>
                                        </div>
                                        <span class="text-sm font-bold text-blue-600">
                                            Rp{{ number_format($bid->harga_penawaran, 0, ',', '.') }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

            </div>
        </div>

    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const timerBox = document.getElementById('timer-box');
            if(!timerBox) return;

            const targetWaktu = new Date(timerBox.getAttribute('data-waktu-selesai')).getTime();
            const displayElement = timerBox.querySelector('.id-countdown');

            function hitungMundur() {
                const sekarang = new Date().getTime();
                const selisih = targetWaktu - sekarang;

                if (selisih <= 0) {
                    displayElement.innerHTML = "Waktu Habis";
                    displayElement.className = "text-lg font-mono font-black tracking-widest text-red-400";
                    return;
                }

                const hari = Math.floor(selisih / (1000 * 60 * 60 * 24));
                const jam = Math.floor((selisih % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const menit = Math.floor((selisih % (1000 * 60 * 60)) / (1000 * 60));
                const detik = Math.floor((selisih % (1000 * 60)) / 1000);

                let teks = "";
                if (hari > 0) teks += `${hari}hari `;
                teks += `${jam.toString().padStart(2, '0')}:${menit.toString().padStart(2, '0')}:${detik.toString().padStart(2, '0')}`;

                displayElement.innerHTML = teks;
            }

            hitungMundur();
            setInterval(hitungMundur, 1000);
        });
    </script>
</body>
</html>