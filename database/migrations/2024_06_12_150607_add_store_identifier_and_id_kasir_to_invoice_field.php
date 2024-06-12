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
        Schema::table('invoice_fields', function (Blueprint $table) {
            $table->bigInteger('id_kasir')->nullable()->after('id_invoice');
            $table->string('store_identifier')->nullable()->after('id_kasir');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoice_fields', function (Blueprint $table) {
            //
        });
    }
};
