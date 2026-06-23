<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lelangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained()->onDelete('cascade'); // Barang yang ditawar
            $table->foreignId('user_id')->constrained()->onDelete('cascade');   // Penawar barang
            $table->integer('harga_penawaran');                                 // Nominal bid
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lelangs');
    }
};