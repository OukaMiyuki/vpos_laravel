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
        Schema::table('settlement_hstories', function (Blueprint $table) {
            $table->bigInteger('id_settlement')->after('id_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settlement_hstories', function (Blueprint $table) {
            //
        });
    }
};
