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
        Schema::create('input_aspirasi', function (Blueprint $table) {
            $table->id('id_pelaporan');
            $table->integer('nis');
            $table->unsignedBigInteger('id_kategori');
            $table->string('lokasi', 50);
            $table->text('ket');
            $table->enum('status', ['Menunggu', 'Proses', 'Selesai', 'Dibatalkan'])->nullable();
            $table->string('gambar')->nullable();
            $table->text('tanggapan_admin')->nullable();
            $table->timestamps();
            $table->foreign('nis')
                ->references('nis')
                ->on('siswa')
                ->onDelete('cascade');

            $table->foreign('id_kategori')
                ->references('id_kategori')
                ->on('kategori')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('input_aspirasi');
        Schema::enableForeignKeyConstraints();
    }
};
