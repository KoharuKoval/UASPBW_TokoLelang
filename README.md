#  Aplikasi Web Toko Lelang Online (Tugas UAS PBW)
Muhammad Athallah Assyarif (2408107010088)

Halo! Selamat datang di repositori proyek **Toko Lelang Online**. Aplikasi web ini saya bangun menggunakan framework **Laravel** sebagai pemenuhan tugas akhir untuk mata kuliah **Pemrograman Berbasis Web (PBW)**. 

Inti dari aplikasi ini adalah platform lelang sederhana di mana pengguna bisa saling mendaftarkan barang dan mengajukan penawaran harga (bidding) secara kompetitif dalam batas waktu yang sudah ditentukan.

---

##  Apa Saja yang Bisa Dilakukan di Web Ini?

* **Daftar & Masuk Akun (Autentikasi):** Web ini aman karena dilengkapi sistem login dan register bawaan Laravel. Pengguna harus masuk dulu sebelum bisa melihat katalog atau ikut menawar barang.
* **Lihat Katalog Barang (Read):** Halaman dashboard utama menampilkan semua barang yang sedang dilelang lengkap dengan harganya saat ini.
* **Daftarkan Barang Baru (CRUD):** Pengguna bisa memasukkan barang lelang baru, mengisi deskripsi, menentukan harga awal, serta mengatur kapan sesi lelang dimulai dan berakhir.
* **Sistem Tawar-Menawar Dinamis (Bidding):** Ini fitur utamanya. Di sisi backend, saya membuat validasi ketat di mana sistem otomatis menolak jika ada pengguna yang memasukkan harga penawaran yang lebih rendah atau sama dengan tawaran tertinggi saat ini.
* **Hitung Mundur Waktu (Real-Time Countdown):** Biar kerasa seperti lelang bervolume tinggi, saya menambahkan script JavaScript murni untuk menampilkan sisa waktu lelang yang terus berkurang setiap detiknya di halaman katalog dan detail barang.
* **Tampilan Rapi & Responsif:** Seluruh antarmuka web ini didesain menggunakan **Tailwind CSS v4** agar terlihat bersih, modern, dan nyaman dilihat di laptop maupun HP.

---

##  Teknologi di Balik Layar

* **Framework:** Laravel 12
* **Database:** MySQL
* **UI Styling:** Tailwind CSS v4 (via CDN)
* **Bahasa Pemrograman:** PHP & JavaScript murni (Vanilla JS)
* **Server Lokal:** XAMPP (Apache & MySQL)

---

##  Cara Menjalankan Proyek Ini di Komputer Lokal

Jika Anda ingin menguji coba proyek ini di lokal, silakan ikuti langkah-langkah santai berikut:

### 1. Download Proyek
Clone repositori ini ke komputer Anda atau langsung download file ZIP-nya:

git clone https://github.com/KoharuKoval/UASPBW_TokoLelang.git
cd NAMA_REPOSITORI

2. Install Library Vendor
Buka terminal/CMD di dalam folder proyek, lalu install library Laravel yang dibutuhkan menggunakan composer:


composer install
3. Atur File .env (Environment)
Salin file .env.example dan ubah namanya menjadi .env:

  cp .env.example .env
Buka file .env tersebut pakai VS Code, lalu pastikan nama databasenya sudah diarahkan ke database kita:

Code snippet
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=toko_lelang
  DB_USERNAME=root
  DB_PASSWORD=

  
4. Buat Kunci Aplikasi (Key Generate)
Jalankan perintah ini di CMD agar Laravel membuatkan kunci keamanan baru:
php artisan key:generate

5. Siapkan Database
Nyalakan XAMPP (Start Apache dan MySQL).

Buka browser ke alamat http://localhost/phpmyadmin/ lalu buat database baru bernama toko_lelang.

Impor file dump database bernama toko_lelang.sql (yang sudah saya sertakan di folder utama proyek ini) langsung ke dalam database tersebut.

Alternatif: Jika ingin membuat struktur tabel kosong yang fresh, Anda bisa langsung ketik:

php artisan migrate

6. Nyalakan Server lokal!
Terakhir, jalankan servernya lewat CMD:

php artisan serve
