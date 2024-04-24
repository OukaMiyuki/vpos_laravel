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
            $table->string('no_ktp')->nullable()->change();
            $table->text('alamat')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_kasirs', function (Blueprint $table) {
            $table->string('no_ktp')->nullable(false)->change();
            $table->text('alamat')->nullable(false)->change();
        });
    }
};
