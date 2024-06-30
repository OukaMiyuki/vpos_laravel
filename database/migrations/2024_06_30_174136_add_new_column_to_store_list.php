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
        Schema::table('store_lists', function (Blueprint $table) {
            $table->string('nama_jalan')->nullable()->after('alamat');
            $table->string('nama_blok')->nullable()->after('nama_jalan');
            $table->string('rt')->nullable()->after('nama_blok');
            $table->string('rw')->nullable()->after('rt');
            $table->string('kelurahan_desa')->nullable()->after('rw');
            $table->string('kecamatan')->nullable()->after('kelurahan_desa');
            $table->string('kantor_toko_fisik')->nullable()->after('jenis_usaha');
            $table->string('kategori_usaha_omset')->nullable()->after('kantor_toko_fisik');
            $table->string('website')->nullable()->after('ktp_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('store_lists', function (Blueprint $table) {
            //
        });
    }
};
