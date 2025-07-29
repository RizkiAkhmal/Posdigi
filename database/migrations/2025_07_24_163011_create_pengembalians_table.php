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
        Schema::create('pengembalians', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_peminjaman');
            $table->string('nama_pengembali');
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali');
            $table->string('jumlah_kembali');
            $table->enum('status', ['pending', 'approved', 'rejected', 'returned'])->default('pending');
            $table->enum('kondisi_buku', ['baik', 'rusak', 'hilang']); 
            $table->decimal('biaya_denda', 12, 2)->default(0);

            $table->foreign('id_peminjaman')->references('id')->on('peminjamans')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalians');
    }
};
