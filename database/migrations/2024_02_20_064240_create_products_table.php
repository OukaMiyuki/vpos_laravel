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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('batch_code')->unique();
            $table->string('product_code')->unique();
            $table->string('product_name');
            $table->bigInteger('id_supplier');
            $table->string('photo')->nullable();
            $table->string('nomor_gudang')->nullable();
            $table->string('nomor_rak')->nullable();
            $table->date('tanggal_beli')->nullable();
            $table->date('tanggal_expired')->nullable();
            $table->string('harga_beli');
            $table->string('harga_jual');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
