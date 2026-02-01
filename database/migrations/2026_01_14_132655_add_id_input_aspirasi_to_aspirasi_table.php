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
        Schema::table('aspirasi', function (Blueprint $table) {
            $table->unsignedBigInteger('id_input_aspirasi')->nullable();
            $table->foreign('id_input_aspirasi')
                ->references('id_pelaporan')
                ->on('input_aspirasi')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aspirasi', function (Blueprint $table) {
            $table->dropForeign(['id_input_aspirasi']);
            $table->dropColumn('id_input_aspirasi');
        });
    }
};
