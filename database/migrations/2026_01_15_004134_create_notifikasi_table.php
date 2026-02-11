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
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id('id_notifikasi');
            $table->string('judul');
            $table->text('pesan');
            $table->string('url')->nullable();
            $table->enum('tipe', ['admin', 'siswa'])->default('admin');
            $table->unsignedBigInteger('id_pengaduan')->nullable();
            $table->boolean('dibaca')->default(false);
            $table->timestamps();
            $table->foreign('id_pengaduan')
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('notifikasi');
        Schema::enableForeignKeyConstraints();
    }
};
