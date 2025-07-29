<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bukus', function (Blueprint $table) {
            $table->id();
            $table->string('foto');
            $table->string('kode_buku');
            $table->string('judul_buku');
            $table->string('penerbit');
            $table->string('pengarang');
            $table->string('tahun_terbit');
            $table->string('halaman');
            $table->string('sinopsis');
            $table->unsignedBigInteger('id_sub_kategori');
            $table->timestamps();

            $table->foreign('id_sub_kategori')->references('id')->on('sub_kategoris')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};

