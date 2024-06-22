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
        Schema::create('settlement_pendings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_user')->nullable();
            $table->string('email')->nullable();
            $table->string('nomor_settlement_pending')->nullable();
            $table->string('settlement_schedule')->nullable();
            $table->string('nominal_settle')->nullable();
            $table->string('nominal_insentif_cashback')->nullable();
            $table->integer('settlement_pending_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settlement_pendings');
    }
};
