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
        Schema::table('detail_penarikans', function (Blueprint $table) {
            $table->string('id_insentif')->after('id_penarikan')->nullable();
            $table->string('nominal')->after('id_insentif')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_penarikans', function (Blueprint $table) {
            //
        });
    }
};
