<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // Ditambahkan
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'mengenal_dari',
        'fasilitas_menarik',
        'alamat_ktp',
        'kode_pos_ktp',
        'alamat_rumah',
        'kode_pos_rumah',
        'telepon_rumah',
        'no_ktp',
        'no_hp',
        'email',
        'pekerjaan',
        'nama_instansi',
        'alamat_instansi',
        'telp_instansi',
        'kode_pos_instansi',
        'nama_referensi_1',
        'no_anggota_referensi_1',
        'nama_referensi_2',
        'no_anggota_referensi_2',
        'path_pas_foto',
        'path_ktp',
        'path_sk_pegawai',
        'tanda_tangan',
        'status',
    ];

    protected $casts = [
        'fasilitas_menarik' => 'array',
    ];

    /**
     * Relasi: Data pendaftaran ini dimiliki oleh satu User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}