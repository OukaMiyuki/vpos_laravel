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
        Schema::create('detail_penarikans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_penarikan')->unique()->nullable();
            $table->string('nominal_penarikan')->nullable();
            $table->string('nominal_bersih_penarikan')->nullable();
            $table->string('total_biaya_admin')->nullable();
            $table->string('biaya_nobu')->nullable();
            $table->string('biaya_mitra')->nullable();
            $table->string('biaya_admin_su')->nullable();
            $table->string('biaya_agregate')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_penarikans');
    }
};
