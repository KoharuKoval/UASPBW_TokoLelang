<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Pemilik barang
            $table->string('nama_barang');
            $table->text('deskripsi');
            $table->integer('harga_awal');
            $table->dateTime('waktu_mulai');
            $table->dateTime('waktu_selesai');
            $table->string('status')->default('aktif'); // aktif / ditutup
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};