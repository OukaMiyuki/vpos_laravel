<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_tenant');
            $table->bigInteger('id_kasir');
            $table->string('nomor_invoice')->unique();
            $table->date('tanggal_transaksi');
            $table->date('tanggal_pelunasan')->nullable();
            $table->string('jenis_pembayaran')->nullable();
            $table->integer('status_pembayaran')->default(1);
            $table->string('nominal_bayar')->nullable();
            $table->string('kembalian')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
