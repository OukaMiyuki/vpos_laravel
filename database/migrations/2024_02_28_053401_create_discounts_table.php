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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_marketing');
            $table->string('name');
            $table->string('product_name')->nullable();
            $table->integer('qty_amount')->default(0);
            $table->string('price_amount')->nullable();
            $table->integer('discount')->nullable();
            $table->integer('is_active')->default(1);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
