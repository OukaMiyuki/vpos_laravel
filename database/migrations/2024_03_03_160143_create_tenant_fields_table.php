<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('tenant_fields', function (Blueprint $table) {
            $table->id();
            $table->string('baris1')->nullable();
            $table->string('baris2')->nullable();
            $table->string('baris3')->nullable();
            $table->string('baris4')->nullable();
            $table->string('baris5')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenant_fields');
    }
};
