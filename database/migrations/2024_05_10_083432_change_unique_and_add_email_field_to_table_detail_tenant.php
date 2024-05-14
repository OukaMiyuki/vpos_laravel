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
        Schema::table('detail_tenants', function (Blueprint $table) {
            $table->string('id_tenant')->unique(false)->nullable()->change();
            $table->string('email')->unique()->after('id_tenant');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_tenants', function (Blueprint $table) {
            //
        });
    }
};
