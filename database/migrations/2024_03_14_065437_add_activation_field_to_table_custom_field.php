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
        Schema::table('tenant_fields', function (Blueprint $table) {
            $table->integer("baris_1_activation")->default(0)->after('baris5');
            $table->integer("baris_2_activation")->default(0)->after('baris_1_activation');
            $table->integer("baris_3_activation")->default(0)->after('baris_2_activation');
            $table->integer("baris_4_activation")->default(0)->after('baris_3_activation');
            $table->integer("baris_5_activation")->default(0)->after('baris_4_activation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenant_fields', function (Blueprint $table) {
            //
        });
    }
};
