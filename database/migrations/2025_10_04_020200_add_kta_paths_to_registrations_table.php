<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->string('path_kta_referensi_1')->nullable()->after('no_anggota_referensi_2');
            $table->string('path_kta_referensi_2')->nullable()->after('path_kta_referensi_1');
        });
    }

    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn(['path_kta_referensi_1', 'path_kta_referensi_2']);
        });
    }
};