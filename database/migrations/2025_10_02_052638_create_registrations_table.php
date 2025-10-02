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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();

            // DATA PRIBADI [cite: 55]
            $table->string('nama_lengkap');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);

            // DATA TEMPAT TINGGAL [cite: 79]
            $table->text('alamat_ktp');
            $table->string('kode_pos_ktp');
            $table->text('alamat_rumah');
            $table->string('kode_pos_rumah');
            $table->string('no_ktp')->unique();
            $table->string('no_hp')->unique();
            $table->string('email')->unique();

            // DATA PEKERJAAN [cite: 90]
            $table->string('pekerjaan');
            $table->string('nama_instansi');
            $table->text('alamat_instansi');
            $table->string('telp_instansi');
            $table->string('kode_pos_instansi');

            // REFERENSI ANGGOTA [cite: 107]
            $table->string('nama_referensi_1');
            $table->string('no_anggota_referensi_1');
            $table->string('nama_referensi_2');
            $table->string('no_anggota_referensi_2');
            
            // DOKUMEN & TANDA TANGAN
            $table->string('path_pas_foto');
            $table->string('path_ktp');
            $table->string('path_sk_pegawai');
            $table->text('tanda_tangan')->nullable(); // Menyimpan base64 atau path gambar

            // Status Pendaftaran untuk Admin
            $table->enum('status', ['Menunggu Verifikasi', 'Disetujui', 'Ditolak'])->default('Menunggu Verifikasi');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};