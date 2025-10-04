<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Registration
 * Menyimpan data pendaftaran anggota, termasuk informasi pribadi, pekerjaan, dan referensi.
 */
class Registration extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable (White-list for mass assignment).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
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
        'path_kta_referensi_1', // Path file KTA referensi 1
        'path_kta_referensi_2', // Path file KTA referensi 2
        'path_pas_foto',
        'path_ktp',
        'path_sk_pegawai',
        'tanda_tangan',
        'status',
        'rejection_reason',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // Cast fasilitas_menarik as an array (assuming it stores multiple choices)
        'fasilitas_menarik' => 'array',
        // Optional: Cast tanggal_lahir to date if needed
        // 'tanggal_lahir' => 'date',
    ];

    /**
     * Relasi: Data pendaftaran ini dimiliki oleh satu User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        // Assuming the 'user_id' column links to the User model
        return $this->belongsTo(User::class);
    }
}
