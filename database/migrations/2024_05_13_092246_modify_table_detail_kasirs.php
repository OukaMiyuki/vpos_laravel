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
        Schema::table('detail_kasirs', function (Blueprint $table) {
            $table->string('id_kasir')->unique(false)->nullable()->change();
            $table->string('email')->unique()->after('id_kasir');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_kasirs', function (Blueprint $table) {
            //
        });
    }
};
