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
        Schema::create('tenant_qris_accounts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_tenant');
            $table->string('email')->unique();
            $table->string('qris_login_user');
            $table->string('qris_password');
            $table->string('qris_merchant_id');
            $table->string('qris_store_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenant_qris_accounts');
    }
};
