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
        Schema::create('qris_a_p_i_settings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_user')->nullable()->unique();
            $table->string('email')->nullable()->uinique();
            $table->string('password')->nullable()->unique();
            $table->string('api_key')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('qris_a_p_i_settings');
    }
};
