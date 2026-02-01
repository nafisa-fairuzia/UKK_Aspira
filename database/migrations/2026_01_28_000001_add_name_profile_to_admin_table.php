<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admin', function (Blueprint $table) {
            if (!Schema::hasColumn('admin', 'nama')) {
                $table->string('nama')->nullable()->after('username');
            }
            if (!Schema::hasColumn('admin', 'profile_pic')) {
                $table->string('profile_pic')->nullable()->after('nama');
            }
        });
    }

    public function down(): void
    {
        Schema::table('admin', function (Blueprint $table) {
            if (Schema::hasColumn('admin', 'profile_pic')) {
                $table->dropColumn('profile_pic');
            }
            if (Schema::hasColumn('admin', 'nama')) {
                $table->dropColumn('nama');
            }
        });
    }
};
