<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class RegistrationController extends Controller
{
    public function store(Request $request)
    {
        // Logika untuk menggabungkan input
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

        // Validasi semua data dari form
        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat_ktp' => 'required|string',
            'kode_pos_ktp' => 'required|string|max:10',
            'alamat_rumah' => 'required|string',
            'kode_pos_rumah' => 'required|string|max:10',
            'telepon_rumah' => 'nullable|string|max:15',
            'no_ktp' => 'required|string|max:20',
            'no_hp' => 'required|string|max:15',
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
            'mengenal_dari' => 'nullable|string',
            'fasilitas_menarik' => 'nullable|array',
        ]);

        // Simpan data yang TIDAK ADA di database ke dalam session
        $request->session()->put('pdf_temp_data', [
            'mengenal_dari' => $validatedData['mengenal_dari'] ?? null,
            'fasilitas_menarik' => $validatedData['fasilitas_menarik'] ?? [],
        ]);

        // Siapkan data yang akan disimpan ke database
        $dbData = $validatedData;
        $dbData['user_id'] = Auth::id();
        $dbData['email'] = Auth::user()->email;
        $dbData['path_pas_foto'] = $request->file('pas_foto')->store('uploads/foto', 'public');
        $dbData['path_ktp'] = $request->file('scan_ktp')->store('uploads/ktp', 'public');
        $dbData['path_sk_pegawai'] = $request->file('scan_sk')->store('uploads/sk', 'public');
        $dbData['tanda_tangan'] = $request->signature;

        // Hapus data yang tidak ada kolomnya di database
        unset(
            $dbData['mengenal_dari'],
            $dbData['fasilitas_menarik'],
            $dbData['pas_foto'],
            $dbData['scan_ktp'],
            $dbData['scan_sk'],
            $dbData['signature']
        );

        // Buat record pendaftaran
        $registration = Registration::create($dbData);

        // Arahkan ke halaman preview
        return redirect()->route('registration.preview', $registration->id);
    }

    public function preview($id)
    {
        $registration = Registration::findOrFail($id);
        if ($registration->user_id !== Auth::id()) {
            abort(403);
        }

        // Ambil data sementara dari session untuk ditampilkan di halaman preview
        $tempData = session('pdf_temp_data', []);
        $registration->mengenal_dari = $tempData['mengenal_dari'] ?? null;
        $registration->fasilitas_menarik = $tempData['fasilitas_menarik'] ?? [];

        return view('registration.preview', compact('registration'));
    }

    public function download($id)
    {
        $registration = Registration::findOrFail($id);
        if ($registration->user_id !== Auth::id()) {
            abort(403);
        }

        // Ambil data sementara dari session untuk PDF
        $tempData = session('pdf_temp_data', []);
        $registration->mengenal_dari = $tempData['mengenal_dari'] ?? null;
        $registration->fasilitas_menarik = $tempData['fasilitas_menarik'] ?? [];

        // Buat PDF dengan data yang sudah digabungkan
        $pdf = Pdf::loadView('pdf.registration', ['registration' => $registration]);

        // Hapus session setelah PDF dibuat agar tidak terpakai lagi
        session()->forget('pdf_temp_data');

        return $pdf->download('formulir-pendaftaran-'.$registration->nama_lengkap.'.pdf');
    }
}