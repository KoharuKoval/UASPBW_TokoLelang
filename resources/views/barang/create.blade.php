<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang Lelang - Toko Lelang</title>
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
                    <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900 font-semibold">Kembali</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-2xl mx-auto px-4 py-10">
        <div class="bg-white p-8 rounded-xl shadow-md border border-gray-200">
            
            <div class="mb-6 border-b border-gray-100 pb-4">
                <h2 class="text-2xl font-bold text-gray-900">Daftarkan Barang Lelang Baru</h2>
                <p class="text-sm text-gray-500 mt-1">Lengkapi informasi produk di bawah ini untuk memulai sesi lelang.</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-600 p-4 rounded-lg text-sm font-medium">
                    <p class="font-bold mb-1">Periksa kembali isian Anda:</p>
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('barang.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="nama_barang" class="block text-sm font-semibold text-gray-700 mb-1">Nama Barang</label>
                    <input id="nama_barang" type="text" name="nama_barang" value="{{ old('nama_barang') }}" required autofocus class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi Barang</label>
                    <textarea id="deskripsi" name="deskripsi" rows="4" required class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('deskripsi') }}</textarea>
                </div>

                <div>
                    <label for="harga_awal" class="block text-sm font-semibold text-gray-700 mb-1">Harga Awal (Rp)</label>
                    <input id="harga_awal" type="number" name="harga_awal" value="{{ old('harga_awal') }}" min="1" required class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="waktu_mulai" class="block text-sm font-semibold text-gray-700 mb-1">Waktu Mulai Lelang</label>
                        <input id="waktu_mulai" type="datetime-local" name="waktu_mulai" value="{{ old('waktu_mulai') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="waktu_selesai" class="block text-sm font-semibold text-gray-700 mb-1">Waktu Selesai Lelang</label>
                        <input id="waktu_selesai" type="datetime-local" name="waktu_selesai" value="{{ old('waktu_selesai') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit" class="px-5 py-2 rounded-lg font-semibold text-sm text-white bg-blue-600 hover:bg-blue-700 transition shadow">
                        Simpan & Publikasikan
                    </button>
                </div>
            </form>

        </div>
    </main>

</body>
</html>