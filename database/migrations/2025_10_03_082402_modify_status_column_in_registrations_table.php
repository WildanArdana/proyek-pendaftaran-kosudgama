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
        Schema::table('registrations', function (Blueprint $table) {
            // Mengubah kolom 'status' untuk menambahkan opsi 'Perlu Revisi'
            $table->enum('status', [
                'Menunggu Verifikasi',
                'Perlu Revisi', // Opsi baru ditambahkan
                'Disetujui',
                'Ditolak'
            ])->default('Menunggu Verifikasi')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            // Mengembalikan ke struktur lama jika migrasi di-rollback
            $table->enum('status', [
                'Menunggu Verifikasi',
                'Disetujui',
                'Ditolak'
            ])->default('Menunggu Verifikasi')->change();
        });
    }
};