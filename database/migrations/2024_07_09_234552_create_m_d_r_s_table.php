<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('m_d_r_s', function (Blueprint $table) {
            $table->id();
            $table->string("jenis_usaha")->nullable();
            $table->string("presentase_minimal_mdr")->nullable();
            $table->string("presentase_maksimal_mdr")->nullable();
            $table->string("nominal_minimal_mdr")->nullable();
            $table->longText("ketentuan")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_d_r_s');
    }
};
