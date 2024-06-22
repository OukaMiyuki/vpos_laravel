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
        Schema::create('history_cashback_pendings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_invoice')->nullable();
            $table->string('nominal_terima_mdr')->nullable();
            $table->string('settlement_status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_cashback_pendings');
    }
};
