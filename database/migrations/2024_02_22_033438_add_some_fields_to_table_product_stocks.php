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
        Schema::table('product_stocks', function (Blueprint $table) {
            $table->date('tanggal_beli')->after('barcode')->nullable();
            $table->date('tanggal_expired')->after('tanggal_beli')->nullable();
            $table->string('harga_beli')->after('tanggal_expired')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_stocks', function (Blueprint $table) {
            //
        });
    }
};
