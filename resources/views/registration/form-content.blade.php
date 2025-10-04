{{-- resources/views/registration/form-content.blade.php --}}

<style>
    .form-container { font-family: 'Arial', sans-serif; position: relative; overflow: hidden; border: 2px solid #000; }
    .form-container::before { content: ""; background-image: url('https://i.ibb.co/L89G0zK/logo-kosudgama-watermark.png'); background-repeat: no-repeat; background-position: center; background-size: contain; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 50%; height: 50%; opacity: 0.1; z-index: 0; }
    .form-content { position: relative; z-index: 1; }
    .header-title { font-family: 'Times New Roman', serif; font-weight: bold; }
    .form-label { font-size: 11px; display: block; margin-bottom: 2px; }
    .form-input, .form-textarea { font-size: 12px; width: 100%; padding: 2px 6px; height: 24px; border: 1px solid #000; background-color: white; }
    .form-textarea { height: auto; }
    .section-title { background-color: #008c4b; color: white; font-weight: bold; padding: 2px 8px; font-size: 13px; text-align: center; }
    .form-check-label { font-size: 11px; margin-left: 4px; }
    .form-checkbox, .form-radio { width: 14px; height: 14px; border: 1px solid #000; }
    .input-group { display: flex; align-items: center; gap: 6px; }
    .input-group .form-label { flex-shrink: 0; }
    .input-group .form-input { flex-grow: 1; }
    .char-box-container { display: flex; gap: 2px; }
    .char-box { width: 22px; height: 24px; text-align: center; padding: 0; border: 1px solid #000; font-size: 14px; }
    .char-box:focus { outline: 2px solid #3b82f6; }
</style>

<div class="form-container bg-white p-4 sm:p-6">
    <div class="form-content">
        <header class="flex items-center justify-between border-b-4 border-black pb-2 mb-2">
            <div><h1 class="header-title text-4xl -mb-2">FORMULIR</h1><p class="font-bold text-lg">Aplikasi Keanggotaan</p></div>
            <div class="text-right">
                <div class="flex justify-end items-center gap-2">
                    <div><h2 class="header-title text-md">KOPERASI KONSUMEN</h2><h2 class="header-title text-md">KOSUDGAMA DAYA GEMILANG</h2><p class="text-xs font-bold">YOGYAKARTA</p></div>
                    <img src="https://i.ibb.co/hK3aL7v/logo-kosudgama.png" alt="Logo KOSUDGAMA" class="h-14">
                </div>
                <p class="text-xs mt-1">Bulaksumur A 14-15, Caturtunggal, Depok, Sleman, Yogyakarta 55281</p>
                <p class="text-xs">Telp. (0274) 514310, 515714, 521123 | Telp. Apotek (0274) 515426</p>
                <p class="text-xs">Website: www.kosudgama.org | E-mail: kosudgama07@yahoo.com</p>
            </div>
        </header>
        <div class="border-2 border-black">
            <div class="section-title">PERSYARATAN</div>
            <div class="p-2 text-xs"><ol class="list-decimal list-inside space-y-1"><li>Bersedia memenuhi Anggaran Dasar, Anggaran Rumah Tangga, Kode Etik dan segala peraturan yang berlaku di KOSUDGAMA.</li><li>Berusia maksimal 60 tahun pada saat pendaftaran.</li><li>Membayar Simpanan Pokok sebesar Rp100.000,- (seratus ribu rupiah).</li><li>Sanggup membayar Simpanan Wajib sebesar Rp 240.000,- per tahun dibayar dimuka.</li><li>Menyerahkan 2 (dua) lembar pas foto berwarna asli terbaru ukuran 2 x 3 cm (bukan croping, hasil scan).</li><li>Menyerahkan 1 (satu) lembar fotocopy identitas diri yang masih berlaku dan fotocopy SK Kepegawaian terakhir.</li><li>Membayar Modal Penyetaraan Anggota yang besarnya ditentukan oleh Pengurus KOSUDGAMA.</li><li>Tidak mengundurkan diri sebagai anggota selama masa 1 (satu) tahun.</li></ol></div>
        </div>
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded relative my-3 text-sm" role="alert"><strong class="font-bold">Terjadi Kesalahan!</strong><ul class="list-disc list-inside mt-1">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul></div>
        @endif

        <form action="{{ isset($registration) ? route('registration.update', $registration->id) : route('registration.store') }}" method="POST" enctype="multipart/form-data" id="registrationForm" class="mt-3 space-y-3">
            @csrf
            @if(isset($registration))
                @method('PATCH')
            @endif
            
            {{-- DATA PRIBADI --}}
            <div class="border-2 border-black"><div class="section-title">DATA PRIBADI</div><div class="p-3 space-y-2"><div class="input-group"><label for="nama_lengkap" class="form-label w-1/3">Nama (20 digit dalam kartu anggota)</label><input type="text" id="nama_lengkap" name="nama_lengkap" class="form-input" required value="{{ old('nama_lengkap') }}" maxlength="20"></div><div class="flex items-center gap-6"><div class="input-group w-2/3"><label for="tempat_lahir" class="form-label">Tempat & Tanggal lahir</label><input type="text" id="tempat_lahir" name="tempat_lahir" class="form-input" required value="{{ old('tempat_lahir') }}"><input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-input" required value="{{ old('tanggal_lahir') }}"></div><div class="input-group w-1/3"><label class="form-label">Jenis Kelamin</label><label class="flex items-center"><input type="radio" name="jenis_kelamin" value="Laki-laki" class="form-radio" required> <span class="form-check-label">Laki-laki</span></label><label class="flex items-center"><input type="radio" name="jenis_kelamin" value="Perempuan" class="form-radio"> <span class="form-check-label">Perempuan</span></label></div></div><div class="input-group"><label class="form-label">Mengenal KOSUDGAMA dari</label><div class="flex items-center justify-around w-full"><label class="flex items-center"><input type="radio" name="mengenal_dari_radio" value="Rekan sejawat" class="form-radio"> <span class="form-check-label">Rekan sejawat</span></label><label class="flex items-center"><input type="radio" name="mengenal_dari_radio" value="Saudara" class="form-radio"> <span class="form-check-label">Saudara</span></label><label class="flex items-center"><input type="radio" name="mengenal_dari_radio" value="Suami/Istri" class="form-radio"> <span class="form-check-label">Suami/Istri</span></label><label class="flex items-center"><input type="radio" name="mengenal_dari_radio" value="Media cetak" class="form-radio"> <span class="form-check-label">Media cetak</span></label><div class="flex items-center"><input type="radio" name="mengenal_dari_radio" value="Lain-lain" class="form-radio" id="mengenal_lain_radio"><label for="mengenal_lain_radio" class="form-check-label mr-2">Lain-lain (sebutkan</label><input type="text" name="mengenal_dari_lainnya" class="form-input w-24" id="mengenal_lain_text"><label class="form-check-label ml-1">)</label></div></div></div><div class="pt-1"><label class="form-label">Fasilitas yang menarik di KOSUDGAMA (boleh diisi lebih dari satu)</label><div class="grid grid-cols-5 gap-x-4 gap-y-1 mt-1"><label class="flex items-center"><input type="checkbox" name="fasilitas_menarik[]" value="Simpanan(SIMANIS & Deposito)" class="form-checkbox"> <span class="form-check-label">Simpanan(SIMANIS & Deposito)</span></label><label class="flex items-center"><input type="checkbox" name="fasilitas_menarik[]" value="Kredit (Uang & Barang)" class="form-checkbox"> <span class="form-check-label">Kredit (Uang & Barang)</span></label><label class="flex items-center"><input type="checkbox" name="fasilitas_menarik[]" value="Dana Simpati" class="form-checkbox"> <span class="form-check-label">Dana Simpati</span></label><label class="flex items-center"><input type="checkbox" name="fasilitas_menarik[]" value="Diskon Pembelian Obat" class="form-checkbox"> <span class="form-check-label">Diskon Pembelian Obat</span></label><label class="flex items-center"><input type="checkbox" name="fasilitas_menarik[]" value="KIPO" class="form-checkbox"> <span class="form-check-label">KIPO</span></label><label class="flex items-center"><input type="checkbox" name="fasilitas_menarik[]" value="Reservasi Tiket" class="form-checkbox"> <span class="form-check-label">Reservasi Tiket</span></label><label class="flex items-center"><input type="checkbox" name="fasilitas_menarik[]" value="Pembuatan/Perpanjangan SIM/STNK" class="form-checkbox"> <span class="form-check-label">Pembuatan/Perpanjangan SIM/STNK</span></label><label class="flex items-center"><input type="checkbox" name="fasilitas_menarik[]" value="Pembuatan Paspor" class="form-checkbox"> <span class="form-check-label">Pembuatan Paspor</span></label><label class="flex items-center"><input type="checkbox" name="fasilitas_menarik[]" value="Swalayan KOSUDGAMA" class="form-checkbox"> <span class="form-check-label">Swalayan KOSUDGAMA</span></label></div></div></div></div>

            {{-- DATA TEMPAT TINGGAL --}}
            <div class="border-2 border-black"><div class="section-title">DATA TEMPAT TINGGAL</div><div class="p-3 space-y-2"><div class="input-group"><label for="alamat_ktp" class="form-label w-32">Alamat di KTP</label><input id="alamat_ktp" name="alamat_ktp" class="form-input" required value="{{ old('alamat_ktp') }}"/><label for="kode_pos_ktp" class="form-label ml-4">Kode Pos</label><input type="text" id="kode_pos_ktp" name="kode_pos_ktp" class="form-input w-24" required value="{{ old('kode_pos_ktp') }}"></div><div class="input-group"><label for="alamat_rumah" class="form-label w-32">Alamat rumah</label><input id="alamat_rumah" name="alamat_rumah" class="form-input" required value="{{ old('alamat_rumah') }}"/><label for="kode_pos_rumah" class="form-label ml-4">Kode Pos</label><input type="text" id="kode_pos_rumah" name="kode_pos_rumah" class="form-input w-24" required value="{{ old('kode_pos_rumah') }}"></div><div class="input-group"><label for="telepon_rumah_boxes" class="form-label w-32">Telepon</label><div id="telepon_rumah_boxes" class="char-box-container">@for ($i = 0; $i < 12; $i++)<input type="text" maxlength="1" class="char-box">@endfor</div><input type="hidden" name="telepon_rumah" id="telepon_rumah" value="{{ old('telepon_rumah') }}"></div><div class="input-group"><label for="no_hp_boxes" class="form-label w-32">Hand Phone</label><div id="no_hp_boxes" class="char-box-container">@for ($i = 0; $i < 13; $i++)<input type="text" maxlength="1" class="char-box">@endfor</div><input type="hidden" name="no_hp" id="no_hp" value="{{ old('no_hp') }}"></div><div class="input-group"><label class="form-label w-32">Kartu Identitas</label><label for="no_ktp_boxes" class="form-label">KTP No.</label><div id="no_ktp_boxes" class="char-box-container">@for ($i = 0; $i < 16; $i++)<input type="text" maxlength="1" class="char-box">@endfor</div><input type="hidden" name="no_ktp" id="no_ktp" value="{{ old('no_ktp') }}"></div><div class="input-group"><label for="email" class="form-label w-32">E-Mail</label><input type="email" id="email" name="email" class="form-input" required value="{{ Auth::user()->email }}" readonly></div></div></div>

            {{-- DATA PEKERJAAN --}}
            <div class="border-2 border-black"><div class="section-title">DATA PEKERJAAN</div><div class="p-3 space-y-2"><div class="input-group"><label class="form-label w-32">Pekerjaan <span class="font-normal text-gray-500 text-xs">(*Coret salah satu)</span></label><div class="grid grid-cols-3 gap-x-4 gap-y-1 w-full"><label class="flex items-center"><input type="radio" name="pekerjaan_radio" value="Pegawai" class="form-radio"> <span class="form-check-label">Pegawai (tetap/honorer)*</span></label><label class="flex items-center"><input type="radio" name="pekerjaan_radio" value="Dosen" class="form-radio" required> <span class="form-check-label">Dosen (tetap/honorer)*</span></label><label class="flex items-center"><input type="radio" name="pekerjaan_radio" value="Ibu Rumah Tangga" class="form-radio"> <span class="form-check-label">Ibu Rumah Tangga</span></label><div class="flex items-center col-span-1"><input type="radio" name="pekerjaan_radio" value="Wiraswasta" class="form-radio" id="pekerjaan_wiraswasta_radio"><label for="pekerjaan_wiraswasta_radio" class="form-check-label mr-2">Wiraswasta (</label><input type="text" name="pekerjaan_wiraswasta" class="form-input flex-grow" id="pekerjaan_wiraswasta_text"><label class="form-check-label ml-1">)</label></div><div class="flex items-center col-span-2"><input type="radio" name="pekerjaan_radio" value="Lain-lain" class="form-radio" id="pekerjaan_lain_radio"><label for="pekerjaan_lain_radio" class="form-check-label mr-2">Lain-lain (sebutkan</label><input type="text" name="pekerjaan_lainnya" class="form-input flex-grow" id="pekerjaan_lain_text"><label class="form-check-label ml-1">)</label></div></div></div><div class="input-group"><label for="nama_instansi" class="form-label w-32">Nama Kantor/Instansi</label><input type="text" id="nama_instansi" name="nama_instansi" class="form-input" required value="{{ old('nama_instansi') }}"></div><div class="input-group"><label for="alamat_instansi" class="form-label w-32">Alamat Kantor</label><input type="text" id="alamat_instansi" name="alamat_instansi" class="form-input" required value="{{ old('alamat_instansi') }}"></div><div class="grid grid-cols-2 gap-x-8"><div class="input-group"><label for="telp_instansi" class="form-label w-32">Telepon</label><input type="text" id="telp_instansi" name="telp_instansi" class="form-input" required value="{{ old('telp_instansi') }}"></div><div class="input-group"><label for="kode_pos_instansi" class="form-label">Kode Pos</label><input type="text" id="kode_pos_instansi" name="kode_pos_instansi" class="form-input w-24" required value="{{ old('kode_pos_instansi') }}"></div></div></div></div>
            
            <div class="grid grid-cols-2 gap-3">
                {{-- REFERENSI ANGGOTA (UPDATED) --}}
                <div class="border-2 border-black">
                     <div class="section-title">REFERENSI ANGGOTA (HARUS 2 ORANG)</div>
                     <div class="p-3 space-y-3">
                        <p class="text-xs italic">"Kami yang bertanda tangan di bawah ini menyatakan mengetahui dan mengenal dengan baik calon anggota KOSUDGAMA yang mengajukan permohonan ini."</p>
                        <div class="space-y-4">
                            {{-- Referensi 1 --}}
                            <div>
                                <div class="input-group">
                                    <label for="nama_referensi_1" class="form-label w-24">1. Nama</label>
                                    <input type="text" id="nama_referensi_1" name="nama_referensi_1" class="form-input" required value="{{ old('nama_referensi_1', $registration->nama_referensi_1 ?? '') }}">
                                </div>
                                <div class="input-group mt-1">
                                    <label for="no_anggota_referensi_1" class="form-label w-24">No. Anggota</label>
                                    <input type="text" id="no_anggota_referensi_1" name="no_anggota_referensi_1" class="form-input" required value="{{ old('no_anggota_referensi_1', $registration->no_anggota_referensi_1 ?? '') }}">
                                </div>
                                <div class="mt-2">
                                    <label for="kta_referensi_1" class="form-label">Upload Scan KTA Referensi 1</label>
                                    @if(isset($registration) && $registration->path_kta_referensi_1)
                                        <p class="text-xs mb-1">File saat ini: <a href="{{ Storage::url($registration->path_kta_referensi_1) }}" target="_blank" class="text-blue-600 underline">Lihat KTA</a></p>
                                    @endif
                                    <input type="file" id="kta_referensi_1" name="kta_referensi_1" class="form-input">
                                </div>
                            </div>
                            {{-- Referensi 2 --}}
                            <div>
                                <div class="input-group">
                                    <label for="nama_referensi_2" class="form-label w-24">2. Nama</label>
                                    <input type="text" id="nama_referensi_2" name="nama_referensi_2" class="form-input" required value="{{ old('nama_referensi_2', $registration->nama_referensi_2 ?? '') }}">
                                </div>
                                <div class="input-group mt-1">
                                    <label for="no_anggota_referensi_2" class="form-label w-24">No. Anggota</label>
                                    <input type="text" id="no_anggota_referensi_2" name="no_anggota_referensi_2" class="form-input" required value="{{ old('no_anggota_referensi_2', $registration->no_anggota_referensi_2 ?? '') }}">
                                </div>
                                 <div class="mt-2">
                                    <label for="kta_referensi_2" class="form-label">Upload Scan KTA Referensi 2</label>
                                    @if(isset($registration) && $registration->path_kta_referensi_2)
                                        <p class="text-xs mb-1">File saat ini: <a href="{{ Storage::url($registration->path_kta_referensi_2) }}" target="_blank" class="text-blue-600 underline">Lihat KTA</a></p>
                                    @endif
                                    <input type="file" id="kta_referensi_2" name="kta_referensi_2" class="form-input">
                                </div>
                            </div>
                        </div>
                     </div>
                </div>

                {{-- PERNYATAAN DAN KUASA --}}
                <div class="border-2 border-black"><div class="section-title">PERNYATAAN DAN KUASA</div><div class="p-3"><p class="text-xs italic">"Dengan mengetahui, memahami dan menyetujui segala persyaratan yang diberikan, kami selaku calon anggota mengajukan permohonan untuk menjadi anggota KOSUDGAMA. Apabila di kemudian hari terdapat hambatan dalam pemenuhan kewajiban dari saya selaku anggota, maka dengan ini memberikan kuasa kepada KOSUDGAMA untuk mengambil segala tindakan yang diperlukan sesuai dengan peraturan yang berlaku."</p><div class="text-center mt-4"><p class="text-xs">Yogyakarta, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p><div class="w-full h-24 my-2 bg-gray-100 border border-black relative"><canvas id="signature-canvas" class="w-full h-full"></canvas></div><div class="flex justify-center items-center"><span class="text-xs font-bold">( {{ Auth::user()->name }} )</span><button type="button" id="clear-signature" class="text-xs text-blue-600 hover:underline ml-2">Ulangi</button></div><input type="hidden" name="signature" id="signature-input"></div></div></div>
            </div>

            {{-- UPLOAD DOKUMEN PENDUKUNG --}}
            <div class="border-2 border-black"><div class="section-title">UPLOAD DOKUMEN PENDUKUNG</div><div class="p-3 grid grid-cols-1 md:grid-cols-3 gap-6"><div><label for="pas_foto" class="form-label">Pas Foto 2x3 Berwarna</label><input type="file" id="pas_foto" name="pas_foto" class="form-input" required></div><div><label for="scan_ktp" class="form-label">Scan/Foto KTP</label><input type="file" id="scan_ktp" name="scan_ktp" class="form-input" required></div><div><label for="scan_sk" class="form-label">Scan/Foto SK Kepegawaian</label><input type="file" id="scan_sk" name="scan_sk" class="form-input" required></div></div></div>
            
            {{-- UNTUK KEPERLUAN KOPERASI --}}
            <div class="border-2 border-black"><div class="section-title">UNTUK KEPERLUAN KOPERASI</div><div class="p-3 text-xs space-y-3"><p>Catatan bagi Pengurus/Petugas:</p><div class="grid grid-cols-2 gap-x-8"><div class="space-y-2"><p class="font-bold">Diperiksa & Disetujui</p><div class="flex items-center gap-2"><label class="form-label w-24 shrink-0">Tanggal</label><div class="flex-grow border-b border-dotted border-black h-4"></div></div><div class="flex items-start gap-2"><label class="form-label w-24 shrink-0">Nama & Tanda Tangan</label><div class="flex-grow"><div class="w-full h-12"></div><div class="border-t border-dotted border-black text-center">(...............................................)</div></div></div></div><div class="space-y-2"><p class="font-bold">Diproses</p><div class="flex items-center gap-2"><label class="form-label w-24 shrink-0">Tanggal</label><div class="flex-grow border-b border-dotted border-black h-4"></div></div><div class="flex items-start gap-2"><label class="form-label w-24 shrink-0">Nama & Tanda Tangan</label><div class="flex-grow"><div class="w-full h-12"></div><div class="border-t border-dotted border-black text-center">(...............................................)</div></div></div></div></div><div class="flex items-center gap-2 pt-2"><label class="form-label">No. Anggota</label><div class="flex gap-1"><div class="w-6 h-6 border border-black bg-gray-100"></div><div class="w-6 h-6 border border-black bg-gray-100"></div><div class="w-6 h-6 border border-black bg-gray-100"></div><div class="w-6 h-6 border border-black bg-gray-100"></div><div class="w-6 h-6 border border-black bg-gray-100"></div><div class="w-6 h-6 border border-black bg-gray-100"></div><div class="w-6 h-6 border border-black bg-gray-100"></div><div class="w-6 h-6 border border-black bg-gray-100"></div></div></div></div></div>
            
            <div class="text-center pt-4"><button type="submit" class="bg-blue-700 text-white font-bold py-2 px-8 rounded hover:bg-blue-800 transition duration-300 shadow-md">KIRIM PENDAFTARAN</button></div>
        </form>
    </div>
</div>