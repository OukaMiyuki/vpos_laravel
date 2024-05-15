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
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_user')->nullable();
            $table->string('email')->nullable();
            $table->date('tanggal_penarikan')->nulable();
            $table->string('nominal')->nulable();
            $table->date('tanggal_masuk')->nulable();
            $table->string('deteksi_ip_address')->nullable();
            $table->string('deteksi_lokasi_penarikan')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
};
