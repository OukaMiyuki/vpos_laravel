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
        Schema::create('wa_otps', function (Blueprint $table) {
            $table->id();
            $table->string('identifier')->nullable();
            $table->string('token')->nullable();
            $table->integer('validity')->default(15);
            $table->tinyInteger('valid')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wa_otps');
    }
};
