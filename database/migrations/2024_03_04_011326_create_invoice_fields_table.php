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
        Schema::create('invoice_fields', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_kasir')->nullable();
            $table->bigInteger('id_invoice')->unique()->nullable();
            $table->bigInteger('id_custom_field')->nullable();
            $table->string("content1")->nullable();
            $table->string("content2")->nullable();
            $table->string("content3")->nullable();
            $table->string("content4")->nullable();
            $table->string("content5")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_fields');
    }
};
