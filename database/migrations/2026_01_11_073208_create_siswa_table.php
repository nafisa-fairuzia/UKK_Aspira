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
        Schema::create('siswa', function (Blueprint $table) {
            $table->integer('nis')->primary();
            $table->string('nama', 100);
            $table->string('username')->nullable()->unique();
            $table->string('password')->nullable();
            $table->unsignedBigInteger('id_kelas');
            $table->string('profile_pic')->nullable();
            $table->timestamps();
            $table->foreign('id_kelas')
                ->references('id')
                ->on('kelas')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('siswa');
        Schema::enableForeignKeyConstraints();
    }
};
