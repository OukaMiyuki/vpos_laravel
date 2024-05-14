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
        Schema::table('customer_identifiers', function (Blueprint $table) {
            $table->bigInteger('id_tenant')->after('id')->nullable();
            $table->string('email')->after('id_tenant')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_identifiers', function (Blueprint $table) {
            //
        });
    }
};
