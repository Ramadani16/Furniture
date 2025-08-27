<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('log_aktivitas', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id'); // ID Penjual yang melakukan aksi
        $table->string('aksi'); // Contoh: "Tambah Produk", "Edit Produk"
        $table->string('model')->nullable(); // Model yang diubah, contoh: "Produk"
        $table->unsignedBigInteger('model_id')->nullable(); // ID dari model yang diubah
        $table->json('perubahan')->nullable(); // Detail before-after
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('penjuals')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_aktivitas');
    }
};
