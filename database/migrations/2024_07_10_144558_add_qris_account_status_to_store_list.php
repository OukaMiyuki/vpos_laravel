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
            $table->integer('status_registrasi_qris')->default(0)->after('status_umi');
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
