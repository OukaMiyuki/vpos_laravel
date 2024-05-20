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
        Schema::create('store_lists', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_user')->nullable();
            $table->string('email')->nullable();
            $table->string('store_identifier')->nullable()->unique();
            $table->string('name')->nullable();
            $table->text('alamat')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('kode_pos')->nullable();
            $table->string('no_telp_toko')->nullable();
            $table->string('jenis_usaha')->nullable();
            $table->integer('status_umi')->default(0);
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_lists');
    }
};
