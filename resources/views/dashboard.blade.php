<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Toko Lelang</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl border-gray-100 mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <span class="text-xl font-bold text-blue-600 tracking-wide">🔨 Toko Lelang</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm font-medium text-gray-700">Halo, {{ Auth::user()->name }}</span>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-semibold cursor-pointer">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Katalog Barang Lelang
                </h2>
                <p class="mt-1 text-sm text-gray-500">Temukan barang impianmu atau daftarkan barang lelang baru.</p>
            </div>
            <div class="mt-4 md:mt-0 md:ml-4">
                <a href="{{ route('barang.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 transition">
                    ➕ Daftarkan Barang Baru
                </a>
            </div>
        </div>

        @if($barangs->isEmpty())
            <div class="text-center py-12 bg-white rounded-xl shadow-sm border border-gray-200">
                <p class="text-gray-500 text-lg">Belum ada barang yang didaftarkan saat ini.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($barangs as $barang)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col justify-between">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-lg font-bold text-gray-900 truncate" style="max-w: 70%;">
                                    {{ $barang->nama_barang }}
                                </h3>
                                @if($barang->status == 'aktif')
                                    <span class="bg-green-100 text-green-800 text-xs px-2.5 py-0.5 rounded-full font-semibold">Aktif</span>
                                @else
                                    <span class="bg-red-100 text-red-800 text-xs px-2.5 py-0.5 rounded-full font-semibold">Ditutup</span>
                                @endif
                            </div>
                            
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                {{ $barang->deskripsi }}
                            </p>

                            <div class="bg-gray-50 p-3 rounded-lg mb-4">
                                <span class="block text-xs text-gray-500 font-semibold uppercase tracking-wider">Harga Awal</span>
                                <span class="text-xl font-black text-gray-900">Rp{{ number_format($barang->harga_awal, 0, ',', '.') }}</span>
                            </div>

                            <div class="bg-gray-900 text-white p-3 rounded-lg flex items-center justify-between" 
                                 data-waktu-selesai="{{ $barang->waktu_selesai }}">
                                <span class="text-xs text-gray-400 font-medium">Sisa Waktu:</span>
                                <span class="text-sm font-mono font-bold tracking-wider countdown-timer">Memuat...</span>
                            </div>
                        </div>

                        <div class="px-6 pb-6 pt-0">
                            <a href="{{ route('barang.show', $barang->id) }}" class="block text-center w-full bg-blue-50 text-blue-600 hover:bg-blue-100 py-2.5 rounded-lg font-bold text-sm transition">
                                Lihat Detail & Tawar
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const timers = document.querySelectorAll('[data-waktu-selesai]');

            function updateCountdowns() {
                const sekarang = new Date().getTime();

                timers.forEach(timer => {
                    const targetWaktu = new Date(timer.getAttribute('data-waktu-selesai')).getTime();
                    const selisih = targetWaktu - sekarang;
                    const displayElement = timer.querySelector('.countdown-timer');

                    if (selisih <= 0) {
                        displayElement.innerHTML = "Waktu Habis";
                        displayElement.classList.remove('text-white');
                        displayElement.classList.add('text-red-400');
                        return;
                    }

                    const hari = Math.floor(selisih / (1000 * 60 * 60 * 24));
                    const jam = Math.floor((selisih % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const menit = Math.floor((selisih % (1000 * 60 * 60)) / (1000 * 60));
                    const detik = Math.floor((selisih % (1000 * 60)) / 1000);

                    let formatTeks = "";
                    if (hari > 0) formatTeks += `${hari}h `;
                    formatTeks += `${jam.toString().padStart(2, '0')}j ${menit.toString().padStart(2, '0')}m ${detik.toString().padStart(2, '0')}d`;

                    displayElement.innerHTML = formatTeks;
                });
            }

            // Jalankan setiap detik
            updateCountdowns();
            setInterval(updateCountdowns, 1000);
        });
    </script>
</body>
</html>