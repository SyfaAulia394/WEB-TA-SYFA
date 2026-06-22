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
    Schema::create('ulasans', function (Blueprint $table) {
        $table->id();
        $table->string('product_slug'); // Menentukan ulasan untuk produk yang mana
        $table->string('nama');
        $table->text('komentar');
        $table->integer('bintang')->default(5); // Menyimpan rating bintang ala Shopee
        $table->timestamps(); // Otomatis menyimpan tanggal & waktu rekam jejak ulasan
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ulasans');
    }
};
