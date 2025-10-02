<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class RegistrationController extends Controller
{
    // Menampilkan halaman formulir pendaftaran
    public function create()
    {
        return view('registration.create');
    }

    // Menyimpan data pendaftaran
    public function store(Request $request)
    {
        // Logika untuk menangani input gabungan
        $mengenalDari = $request->input('mengenal_dari_radio');
        if ($mengenalDari === 'Lain-lain') {
            $request->merge(['mengenal_dari' => $request->input('mengenal_dari_lainnya')]);
        } else {
            $request->merge(['mengenal_dari' => $mengenalDari]);
        }

        $pekerjaan = $request->input('pekerjaan_radio');
        if ($pekerjaan === 'Wiraswasta') {
            $request->merge(['pekerjaan' => 'Wiraswasta: ' . $request->input('pekerjaan_wiraswasta')]);
        } elseif ($pekerjaan === 'Lain-lain') {
            $request->merge(['pekerjaan' => 'Lain-lain: ' . $request->input('pekerjaan_lainnya')]);
        } else {
            $request->merge(['pekerjaan' => $pekerjaan]);
        }

        // Validasi data
        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string|max:20',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'mengenal_dari' => 'nullable|string|max:255',
            'fasilitas_menarik' => 'nullable|array',
            'alamat_ktp' => 'required|string',
            'kode_pos_ktp' => 'required|string|max:10',
            'alamat_rumah' => 'required|string',
            'kode_pos_rumah' => 'required|string|max:10',
            'telepon_rumah' => 'nullable|string|max:15',
            'no_ktp' => 'required|string|max:20|unique:registrations',
            'no_hp' => 'required|string|max:15|unique:registrations',
            'email' => 'required|email|unique:registrations',
            'pekerjaan' => 'required|string|max:255',
            'nama_instansi' => 'required|string|max:255',
            'alamat_instansi' => 'required|string',
            'telp_instansi' => 'required|string|max:15',
            'kode_pos_instansi' => 'required|string|max:10',
            'nama_referensi_1' => 'required|string|max:255',
            'no_anggota_referensi_1' => 'required|string|max:255',
            'nama_referensi_2' => 'required|string|max:255',
            'no_anggota_referensi_2' => 'required|string|max:255',
            'pas_foto' => 'required|image|max:2048',
            'scan_ktp' => 'required|image|max:2048',
            'scan_sk' => 'required|image|max:2048',
            'signature' => 'required|string',
        ]);

        // Simpan file
        $validatedData['path_pas_foto'] = $request->file('pas_foto')->store('public/uploads/foto');
        $validatedData['path_ktp'] = $request->file('scan_ktp')->store('public/uploads/ktp');
        $validatedData['path_sk_pegawai'] = $request->file('scan_sk')->store('public/uploads/sk');
        $validatedData['tanda_tangan'] = $request->signature;

        Registration::create($validatedData);

        return redirect()->route('registration.success');
    }

    public function success()
    {
        return view('registration.success');
    }
}