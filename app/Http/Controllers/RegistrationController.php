<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf; // Import PDF

class RegistrationController extends Controller
{
    public function store(Request $request)
    {
        // ... (Logika input gabungan tetap sama)
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
        ]);

        $validatedData['user_id'] = Auth::id();
        $validatedData['email'] = Auth::user()->email;

        // Simpan file ke storage
        $validatedData['path_pas_foto'] = $request->file('pas_foto')->store('uploads/foto', 'public');
        $validatedData['path_ktp'] = $request->file('scan_ktp')->store('uploads/ktp', 'public');
        $validatedData['path_sk_pegawai'] = $request->file('scan_sk')->store('uploads/sk', 'public');
        $validatedData['tanda_tangan'] = $request->signature;

        // Simpan data ke database
        $registration = Registration::create($validatedData);

        // Setelah berhasil, arahkan ke halaman preview PDF
        return redirect()->route('registration.preview', $registration->id);
    }

    // FUNGSI BARU: Menampilkan preview PDF
    public function preview($id)
    {
        $registration = Registration::findOrFail($id);
        // Pastikan hanya user yang bersangkutan yang bisa melihat preview-nya
        if ($registration->user_id !== Auth::id()) {
            abort(403);
        }
        return view('registration.preview', compact('registration'));
    }

    // FUNGSI BARU: Download PDF
    public function download($id)
    {
        $registration = Registration::findOrFail($id);
        if ($registration->user_id !== Auth::id()) {
            abort(403);
        }

        $pdf = Pdf::loadView('pdf.registration', ['registration' => $registration]);
        return $pdf->download('formulir-pendaftaran-'.$registration->nama_lengkap.'.pdf');
    }
}