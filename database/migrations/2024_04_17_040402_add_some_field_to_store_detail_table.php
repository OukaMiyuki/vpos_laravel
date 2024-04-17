<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('store_details', function (Blueprint $table) {
            $table->string('no_telp_toko')->after('alamat')->nullable();
            $table->text('catatan_kaki')->after('status_umi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('store_details', function (Blueprint $table) {
            //
        });
    }
};
