<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rule;

class RegistrationController extends Controller
{
    /**
     * Store a newly created registration in storage.
     */
    public function store(Request $request)
    {
        // 1. Logika untuk menggabungkan input dari radio button atau input teks lainnya
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

        // 2. Validasi semua data dari form (Wajib ada file KTA)
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
            'no_ktp' => 'required|string|max:20|unique:registrations',
            'no_hp' => 'required|string|max:15|unique:registrations',
            'pekerjaan' => 'required|string|max:255',
            'nama_instansi' => 'required|string|max:255',
            'alamat_instansi' => 'required|string',
            'telp_instansi' => 'required|string|max:15',
            'kode_pos_instansi' => 'required|string|max:10',
            'nama_referensi_1' => 'required|string|max:255',
            'no_anggota_referensi_1' => 'required|string|max:255',
            'kta_referensi_1' => 'required|image|max:2048', // FILE KTA 1 BARU
            'nama_referensi_2' => 'required|string|max:255',
            'no_anggota_referensi_2' => 'required|string|max:255',
            'kta_referensi_2' => 'required|image|max:2048', // FILE KTA 2 BARU
            'pas_foto' => 'required|image|max:2048',
            'scan_ktp' => 'required|image|max:2048',
            'scan_sk' => 'required|image|max:2048',
            'signature' => 'required|string',
            'mengenal_dari' => 'nullable|string',
            'fasilitas_menarik' => 'nullable|array',
        ]);

        // 3. Simpan data yang TIDAK ADA di database ke dalam session (untuk keperluan preview/PDF)
        $request->session()->put('pdf_temp_data', [
            'mengenal_dari' => $validatedData['mengenal_dari'] ?? null,
            'fasilitas_menarik' => $validatedData['fasilitas_menarik'] ?? [],
        ]);

        // 4. Siapkan data yang akan disimpan ke database (termasuk path file)
        $dbData = $validatedData;
        $dbData['user_id'] = Auth::id();
        $dbData['email'] = Auth::user()->email;

        // Simpan File
        $dbData['path_pas_foto'] = $request->file('pas_foto')->store('uploads/foto', 'public');
        $dbData['path_ktp'] = $request->file('scan_ktp')->store('uploads/ktp', 'public');
        $dbData['path_sk_pegawai'] = $request->file('scan_sk')->store('uploads/sk', 'public');
        $dbData['path_kta_referensi_1'] = $request->file('kta_referensi_1')->store('uploads/referensi_kta', 'public');
        $dbData['path_kta_referensi_2'] = $request->file('kta_referensi_2')->store('uploads/referensi_kta', 'public');
        $dbData['tanda_tangan'] = $request->signature;

        // 5. Hapus input file/temporary field yang tidak ada kolomnya di database
        unset(
            $dbData['mengenal_dari'],
            $dbData['fasilitas_menarik'],
            $dbData['pas_foto'],
            $dbData['scan_ktp'],
            $dbData['scan_sk'],
            $dbData['kta_referensi_1'], // Hapus input file
            $dbData['kta_referensi_2'], // Hapus input file
            $dbData['signature']
        );

        // 6. Buat record pendaftaran
        $registration = Registration::create($dbData);

        // 7. Arahkan ke halaman preview
        return redirect()->route('registration.preview', $registration->id);
    }

    /**
     * Show the preview of the registration form.
     */
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

    /**
     * Download the registration form as a PDF.
     */
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

        return $pdf->download('formulir-pendaftaran-' . $registration->nama_lengkap . '.pdf');
    }

    /**
     * Menampilkan formulir untuk diedit.
     */
    public function edit(Registration $registration)
    {
        // Pastikan hanya pemilik yang bisa mengedit
        if ($registration->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        return view('registration.edit', compact('registration'));
    }

    /**
     * Memproses perubahan dari formulir edit.
     */
    public function update(Request $request, Registration $registration)
    {
        if ($registration->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // 1. Logika untuk menggabungkan input dari radio button (sama seperti di fungsi store)
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

        // 2. Validasi data (file/image dibuat opsional/nullable)
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
            // Gunakan Rule::unique()->ignore($registration->id) agar record sendiri bisa diabaikan
            'no_ktp' => ['required', 'string', 'max:20', Rule::unique('registrations')->ignore($registration->id)],
            'no_hp' => ['required', 'string', 'max:15', Rule::unique('registrations')->ignore($registration->id)],
            'pekerjaan' => 'required|string|max:255',
            'nama_instansi' => 'required|string|max:255',
            'alamat_instansi' => 'required|string',
            'telp_instansi' => 'required|string|max:15',
            'kode_pos_instansi' => 'required|string|max:10',
            'nama_referensi_1' => 'required|string|max:255',
            'no_anggota_referensi_1' => 'required|string|max:255',
            'kta_referensi_1' => 'nullable|image|max:2048', // FILE KTA 1 Opsional
            'nama_referensi_2' => 'required|string|max:255',
            'no_anggota_referensi_2' => 'required|string|max:255',
            'kta_referensi_2' => 'nullable|image|max:2048', // FILE KTA 2 Opsional
            'pas_foto' => 'nullable|image|max:2048', // Opsional
            'scan_ktp' => 'nullable|image|max:2048', // Opsional
            'scan_sk' => 'nullable|image|max:2048', // Opsional
        ]);

        $updateData = $validatedData;

        // 3. Logika untuk mengganti file jika ada file baru yang di-upload
        $this->handleFileUpload($request, $registration, 'pas_foto', 'path_pas_foto', 'uploads/foto', $updateData);
        $this->handleFileUpload($request, $registration, 'scan_ktp', 'path_ktp', 'uploads/ktp', $updateData);
        $this->handleFileUpload($request, $registration, 'scan_sk', 'path_sk_pegawai', 'uploads/sk', $updateData);

        // Logika untuk file KTA Referensi BARU
        $this->handleFileUpload($request, $registration, 'kta_referensi_1', 'path_kta_referensi_1', 'uploads/referensi_kta', $updateData);
        $this->handleFileUpload($request, $registration, 'kta_referensi_2', 'path_kta_referensi_2', 'uploads/referensi_kta', $updateData);
        
        // Hapus input file dari data update agar tidak disimpan ke database
        unset(
            $updateData['kta_referensi_1'],
            $updateData['kta_referensi_2'],
            $updateData['pas_foto'],
            $updateData['scan_ktp'],
            $updateData['scan_sk']
        );
        
        // 4. Set status kembali ke "Menunggu Verifikasi" dan hapus catatan revisi
        $updateData['status'] = 'Menunggu Verifikasi';
        $updateData['rejection_reason'] = null;

        // 5. Update data pendaftaran
        $registration->update($updateData);

        return redirect()->route('dashboard')->with('status', 'Perubahan berhasil disimpan dan data Anda telah dikirim ulang untuk verifikasi.');
    }

    /**
     * Helper function untuk mengelola upload file saat update.
     */
    protected function handleFileUpload(Request $request, Registration $registration, $requestKey, $modelKey, $path, &$updateData)
    {
        if ($request->hasFile($requestKey)) {
            // Hapus file lama jika ada
            if ($registration->$modelKey) {
                Storage::disk('public')->delete($registration->$modelKey);
            }
            // Simpan file baru
            $updateData[$modelKey] = $request->file($requestKey)->store($path, 'public');
        }
    }


    /**
     * Menghapus pendaftaran yang ada agar user bisa mendaftar ulang.
     */
    public function resetRegistration()
    {
        $registration = Auth::user()->registration;

        if ($registration) {
            // Hapus semua file yang ter-upload dari storage
            $filesToDelete = [
                $registration->path_pas_foto,
                $registration->path_ktp,
                $registration->path_sk_pegawai,
                $registration->path_kta_referensi_1, // Tambahkan KTA 1
                $registration->path_kta_referensi_2, // Tambahkan KTA 2
            ];

            // Hapus file dari storage
            Storage::disk('public')->delete(array_filter($filesToDelete));

            // Hapus data dari database
            $registration->delete();

            return redirect()->route('dashboard')->with('status', 'Data lama telah dihapus. Silakan isi kembali formulir pendaftaran.');
        }

        return redirect()->route('dashboard');
    }
}
