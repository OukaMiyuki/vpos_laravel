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
        Schema::create('callback_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('nomor_invoice')->nullable();
            $table->string('responseStatus')->nullable();
            $table->integer('responseCode')->nullable();
            $table->string('responseDescription')->nullable();
            $table->string('partnerTransactionNo')->nullable();
            $table->string('partnerReferenceNo')->nullable();
            $table->string('partnerCallbackReference')->nullable();
            $table->string('partnerTransactionStatus')->nullable();
            $table->timestamp('partnerPaymentTimeStamp')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('callback_histories');
    }
};
