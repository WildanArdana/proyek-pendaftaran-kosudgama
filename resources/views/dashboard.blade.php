<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if(Auth::user()->registration)
                {{ __('Dashboard') }}
            @else
                Formulir Aplikasi Keanggotaan
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @php
                $registration = Auth::user()->registration;
            @endphp

            @if ($registration)
                {{-- TAMPILAN JIKA PENGGUNA SUDAH MENGISI FORMULIR --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        @if (session('status'))
                            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                                <span class="block sm:inline">{{ session('status') }}</span>
                            </div>
                        @endif

                        <h3 class="text-lg font-medium">Selamat Datang, {{ Auth::user()->name }}!</h3>
                        <p class="mt-2">Terima kasih telah mengirimkan formulir pendaftaran Anda pada tanggal {{ $registration->created_at->translatedFormat('d F Y') }}.</p>
                        
                        <div class="mt-4 p-4 border rounded-lg">
                            <h4 class="font-semibold">Status Pendaftaran Anda:</h4>
                            
                            @if($registration->status == 'Menunggu Verifikasi')
                                <p class="text-lg font-bold text-yellow-600">{{ $registration->status }}</p>
                                <p class="text-sm text-gray-600">Tim kami akan segera memeriksa data dan dokumen yang Anda kirimkan. Mohon ditunggu.</p>
                            
                            @elseif($registration->status == 'Perlu Revisi')
                                <p class="text-lg font-bold text-red-600">{{ $registration->status }}</p>
                                <div class="mt-2 p-3 bg-red-50 border border-red-200 rounded-md">
                                    <h5 class="font-semibold text-red-800">Catatan dari Admin:</h5>
                                    <p class="text-sm text-red-700 whitespace-pre-line">{{ $registration->rejection_reason }}</p>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('registration.edit', $registration->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 active:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Perbaiki Pendaftaran
                                    </a>
                                </div>

                            @elseif($registration->status == 'Disetujui')
                                <p class="text-lg font-bold text-green-600">{{ $registration->status }}</p>
                                <p class="text-sm text-gray-600">Selamat! Anda telah diterima sebagai anggota KOSUDGAMA.</p>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                {{-- TAMPILAN JIKA PENGGUNA BELUM MENGISI FORMULIR --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <p class="mb-4 text-gray-600">Selamat Datang, **{{ Auth::user()->name }}**! Anda telah berhasil membuat akun. Silakan lengkapi formulir aplikasi keanggotaan KOSUDGAMA di bawah ini.</p>
                        
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
                            .input-group { display: flex; align-items: center; gap: 1rem; }
                            .input-group.items-start { align-items: flex-start; }
                            .input-group .form-label { flex-shrink: 0; }
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
                                             <img src="{{ asset('images/logo.png') }}" alt="Logo KOSUDGAMA" class="h-14">
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
                                <form action="{{ route('registration.store') }}" method="POST" enctype="multipart/form-data" id="registrationForm" class="mt-3 space-y-3">
                                    @csrf
                                    {{-- DATA PRIBADI --}}
                                    <div class="border-2 border-black">
                                        <div class="section-title">DATA PRIBADI</div>
                                        <div class="p-3 space-y-3">
                                            <div class="input-group">
                                                <label for="nama_lengkap" class="form-label w-48">Nama (20 digit dalam kartu anggota)</label>
                                                <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-input" required value="{{ old('nama_lengkap') }}" maxlength="20">
                                            </div>
                                            <div class="input-group">
                                                <label class="form-label w-48">Tempat & Tanggal lahir</label>
                                                <div class="flex-grow grid grid-cols-2 gap-4">
                                                    <div class="flex items-center gap-2">
                                                        <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-input" required value="{{ old('tempat_lahir') }}" placeholder="Tempat lahir">
                                                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-input" required value="{{ old('tanggal_lahir') }}">
                                                    </div>
                                                    <div class="flex items-center gap-4">
                                                        <label class="form-label">Jenis Kelamin</label>
                                                        <label class="flex items-center"><input type="radio" name="jenis_kelamin" value="Laki-laki" class="form-radio" required> <span class="form-check-label">Laki-laki</span></label>
                                                        <label class="flex items-center"><input type="radio" name="jenis_kelamin" value="Perempuan" class="form-radio"> <span class="form-check-label">Perempuan</span></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="input-group">
                                                <label class="form-label w-48">Mengenal KOSUDGAMA dari</label>
                                                <div class="flex items-center justify-start gap-4 flex-wrap w-full">
                                                    <label class="flex items-center"><input type="radio" name="mengenal_dari_radio" value="Rekan sejawat" class="form-radio"> <span class="form-check-label">Rekan sejawat</span></label>
                                                    <label class="flex items-center"><input type="radio" name="mengenal_dari_radio" value="Saudara" class="form-radio"> <span class="form-check-label">Saudara</span></label>
                                                    <label class="flex items-center"><input type="radio" name="mengenal_dari_radio" value="Suami/Istri" class="form-radio"> <span class="form-check-label">Suami/Istri</span></label>
                                                    <label class="flex items-center"><input type="radio" name="mengenal_dari_radio" value="Media cetak" class="form-radio"> <span class="form-check-label">Media cetak</span></label>
                                                    <div class="flex items-center">
                                                        <input type="radio" name="mengenal_dari_radio" value="Lain-lain" class="form-radio" id="mengenal_lain_radio">
                                                        <label for="mengenal_lain_radio" class="form-check-label mr-2">Lain-lain (sebutkan</label>
                                                        <input type="text" name="mengenal_dari_lainnya" class="form-input w-24" id="mengenal_lain_text">
                                                        <label class="form-check-label ml-1">)</label>
                                                    </div>
                                                </div>
                                            </div>
                                             <div class="input-group items-start">
                                                <label class="form-label w-48 pt-1">Fasilitas yang menarik</label>
                                                <div class="flex-grow grid grid-cols-3 gap-x-4 gap-y-2">
                                                    <label class="flex items-center"><input type="checkbox" name="fasilitas_menarik[]" value="Simpanan(SIMANIS & Deposito)" class="form-checkbox"> <span class="form-check-label">Simpanan(SIMANIS & Deposito)</span></label>
                                                    <label class="flex items-center"><input type="checkbox" name="fasilitas_menarik[]" value="Kredit (Uang & Barang)" class="form-checkbox"> <span class="form-check-label">Kredit (Uang & Barang)</span></label>
                                                    <label class="flex items-center"><input type="checkbox" name="fasilitas_menarik[]" value="Dana Simpati" class="form-checkbox"> <span class="form-check-label">Dana Simpati</span></label>
                                                    <label class="flex items-center"><input type="checkbox" name="fasilitas_menarik[]" value="Diskon Pembelian Obat" class="form-checkbox"> <span class="form-check-label">Diskon Pembelian Obat</span></label>
                                                    <label class="flex items-center"><input type="checkbox" name="fasilitas_menarik[]" value="KIPO" class="form-checkbox"> <span class="form-check-label">KIPO</span></label>
                                                    <label class="flex items-center"><input type="checkbox" name="fasilitas_menarik[]" value="Reservasi Tiket" class="form-checkbox"> <span class="form-check-label">Reservasi Tiket</span></label>
                                                    <label class="flex items-center"><input type="checkbox" name="fasilitas_menarik[]" value="Pembuatan/Perpanjangan SIM/STNK" class="form-checkbox"> <span class="form-check-label">Pembuatan/Perpanjangan SIM/STNK</span></label>
                                                    <label class="flex items-center"><input type="checkbox" name="fasilitas_menarik[]" value="Pembuatan Paspor" class="form-checkbox"> <span class="form-check-label">Pembuatan Paspor</span></label>
                                                    <label class="flex items-center"><input type="checkbox" name="fasilitas_menarik[]" value="Swalayan KOSUDGAMA" class="form-checkbox"> <span class="form-check-label">Swalayan KOSUDGAMA</span></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- DATA TEMPAT TINGGAL --}}
                                    <div class="border-2 border-black">
                                        <div class="section-title">DATA TEMPAT TINGGAL</div>
                                        <div class="p-3 space-y-3">
                                            <div class="input-group">
                                                <label for="alamat_ktp" class="form-label w-48">Alamat di KTP</label>
                                                <input id="alamat_ktp" name="alamat_ktp" class="form-input" required value="{{ old('alamat_ktp') }}"/>
                                            </div>
                                            <div class="input-group">
                                                <label for="kode_pos_ktp" class="form-label w-48">Kode Pos KTP</label>
                                                <input type="text" id="kode_pos_ktp" name="kode_pos_ktp" class="form-input w-24" required value="{{ old('kode_pos_ktp') }}">
                                            </div>
                                            <div class="input-group">
                                                <label for="alamat_rumah" class="form-label w-48">Alamat rumah</label>
                                                <input id="alamat_rumah" name="alamat_rumah" class="form-input" required value="{{ old('alamat_rumah') }}"/>
                                            </div>
                                            <div class="input-group">
                                                <label for="kode_pos_rumah" class="form-label w-48">Kode Pos Rumah</label>
                                                <input type="text" id="kode_pos_rumah" name="kode_pos_rumah" class="form-input w-24" required value="{{ old('kode_pos_rumah') }}">
                                            </div>
                                            <div class="input-group">
                                                <label for="telepon_rumah_boxes" class="form-label w-48">Telepon</label>
                                                <div id="telepon_rumah_boxes" class="char-box-container">@for ($i = 0; $i < 12; $i++)<input type="text" maxlength="1" class="char-box">@endfor</div>
                                                <input type="hidden" name="telepon_rumah" id="telepon_rumah" value="{{ old('telepon_rumah') }}">
                                            </div>
                                            <div class="input-group">
                                                <label for="no_hp_boxes" class="form-label w-48">Hand Phone</label>
                                                <div id="no_hp_boxes" class="char-box-container">@for ($i = 0; $i < 13; $i++)<input type="text" maxlength="1" class="char-box">@endfor</div>
                                                <input type="hidden" name="no_hp" id="no_hp" value="{{ old('no_hp') }}">
                                            </div>
                                            <div class="input-group">
                                                <label for="no_ktp_boxes" class="form-label w-48">No. KTP</label>
                                                <div id="no_ktp_boxes" class="char-box-container">@for ($i = 0; $i < 16; $i++)<input type="text" maxlength="1" class="char-box">@endfor</div>
                                                <input type="hidden" name="no_ktp" id="no_ktp" value="{{ old('no_ktp') }}">
                                            </div>
                                            <div class="input-group">
                                                <label for="email" class="form-label w-48">E-Mail</label>
                                                <input type="email" id="email" name="email" class="form-input" required value="{{ Auth::user()->email }}" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- DATA PEKERJAAN --}}
                                    <div class="border-2 border-black">
                                        <div class="section-title">DATA PEKERJAAN</div>
                                        <div class="p-3 space-y-3">
                                            <div class="input-group items-start">
                                                <label class="form-label w-48 pt-1">Pekerjaan</label>
                                                <div class="flex-grow grid grid-cols-2 gap-x-4 gap-y-2">
                                                    <label class="flex items-center"><input type="radio" name="pekerjaan_radio" value="Pegawai" class="form-radio"> <span class="form-check-label">Pegawai (tetap/honorer)</span></label>
                                                    <label class="flex items-center"><input type="radio" name="pekerjaan_radio" value="Dosen" class="form-radio" required> <span class="form-check-label">Dosen (tetap/honorer)</span></label>
                                                    <label class="flex items-center"><input type="radio" name="pekerjaan_radio" value="Ibu Rumah Tangga" class="form-radio"> <span class="form-check-label">Ibu Rumah Tangga</span></label>
                                                    <div class="flex items-center col-span-2">
                                                        <input type="radio" name="pekerjaan_radio" value="Wiraswasta" class="form-radio" id="pekerjaan_wiraswasta_radio">
                                                        <label for="pekerjaan_wiraswasta_radio" class="form-check-label mr-2">Wiraswasta (</label>
                                                        <input type="text" name="pekerjaan_wiraswasta" class="form-input flex-grow" id="pekerjaan_wiraswasta_text">
                                                        <label class="form-check-label ml-1">)</label>
                                                    </div>
                                                    <div class="flex items-center col-span-2">
                                                        <input type="radio" name="pekerjaan_radio" value="Lain-lain" class="form-radio" id="pekerjaan_lain_radio">
                                                        <label for="pekerjaan_lain_radio" class="form-check-label mr-2">Lain-lain (sebutkan</label>
                                                        <input type="text" name="pekerjaan_lainnya" class="form-input flex-grow" id="pekerjaan_lain_text">
                                                        <label class="form-check-label ml-1">)</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="input-group">
                                                <label for="nama_instansi" class="form-label w-48">Nama Kantor/Instansi</label>
                                                <input type="text" id="nama_instansi" name="nama_instansi" class="form-input" required value="{{ old('nama_instansi') }}">
                                            </div>
                                            <div class="input-group">
                                                <label for="alamat_instansi" class="form-label w-48">Alamat Kantor</label>
                                                <input type="text" id="alamat_instansi" name="alamat_instansi" class="form-input" required value="{{ old('alamat_instansi') }}">
                                            </div>
                                            <div class="input-group">
                                                <label class="form-label w-48">Telepon & Kode Pos Kantor</label>
                                                <div class="flex-grow flex items-center gap-4">
                                                    <input type="text" id="telp_instansi" name="telp_instansi" class="form-input" required value="{{ old('telp_instansi') }}" placeholder="Nomor Telepon">
                                                    <input type="text" id="kode_pos_instansi" name="kode_pos_instansi" class="form-input w-24" required value="{{ old('kode_pos_instansi') }}" placeholder="Kode Pos">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-3">
                                        {{-- REFERENSI ANGGOTA --}}
                                        <div class="border-2 border-black">
                                             <div class="section-title">REFERENSI ANGGOTA (HARUS 2 ORANG)</div>
                                             <div class="p-3 space-y-3">
                                                <p class="text-xs italic">"Kami yang bertanda tangan di bawah ini menyatakan mengetahui dan mengenal dengan baik calon anggota..."</p>
                                                {{-- Referensi 1 --}}
                                                <div class="space-y-2">
                                                    <div class="input-group">
                                                        <label for="nama_referensi_1" class="form-label w-32">1. Nama Referensi</label>
                                                        <input type="text" id="nama_referensi_1" name="nama_referensi_1" class="form-input" required value="{{ old('nama_referensi_1') }}">
                                                    </div>
                                                    <div class="input-group">
                                                        <label for="no_anggota_referensi_1" class="form-label w-32">No. Anggota</label>
                                                        <input type="text" id="no_anggota_referensi_1" name="no_anggota_referensi_1" class="form-input" required value="{{ old('no_anggota_referensi_1') }}">
                                                    </div>
                                                    <div class="input-group">
                                                        <label for="kta_referensi_1" class="form-label w-32">Upload Scan KTA</label>
                                                        <input type="file" id="kta_referensi_1" name="kta_referensi_1" class="form-input" required>
                                                    </div>
                                                </div>
                                                <hr>
                                                {{-- Referensi 2 --}}
                                                <div class="space-y-2">
                                                    <div class="input-group">
                                                        <label for="nama_referensi_2" class="form-label w-32">2. Nama Referensi</label>
                                                        <input type="text" id="nama_referensi_2" name="nama_referensi_2" class="form-input" required value="{{ old('nama_referensi_2') }}">
                                                    </div>
                                                    <div class="input-group">
                                                        <label for="no_anggota_referensi_2" class="form-label w-32">No. Anggota</label>
                                                        <input type="text" id="no_anggota_referensi_2" name="no_anggota_referensi_2" class="form-input" required value="{{ old('no_anggota_referensi_2') }}">
                                                    </div>
                                                     <div class="input-group">
                                                        <label for="kta_referensi_2" class="form-label w-32">Upload Scan KTA</label>
                                                        <input type="file" id="kta_referensi_2" name="kta_referensi_2" class="form-input" required>
                                                    </div>
                                                </div>
                                             </div>
                                        </div>
                                        {{-- PERNYATAAN DAN KUASA --}}
                                        <div class="border-2 border-black flex flex-col">
                                            <div class="section-title">PERNYATAAN DAN KUASA</div>
                                            <div class="p-3 flex-grow flex flex-col justify-between">
                                                <p class="text-xs italic">"Dengan mengetahui, memahami dan menyetujui segala persyaratan yang diberikan, kami selaku calon anggota mengajukan permohonan untuk menjadi anggota KOSUDGAMA. Apabila di kemudian hari terdapat hambatan dalam pemenuhan kewajiban dari saya selaku anggota, maka dengan ini memberikan kuasa kepada KOSUDGAMA untuk mengambil segala tindakan yang diperlukan sesuai dengan peraturan yang berlaku."</p>
                                                <div class="text-center mt-4">
                                                    <p class="text-xs">Yogyakarta, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                                                    <div class="w-full h-24 my-2 bg-gray-100 border border-black relative">
                                                        <canvas id="signature-canvas" class="w-full h-full"></canvas>
                                                    </div>
                                                    <div class="flex justify-center items-center">
                                                        <span class="text-xs font-bold">( {{ Auth::user()->name }} )</span>
                                                        <button type="button" id="clear-signature" class="text-xs text-blue-600 hover:underline ml-2">Ulangi</button>
                                                    </div>
                                                    <input type="hidden" name="signature" id="signature-input">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="border-2 border-black"><div class="section-title">UPLOAD DOKUMEN PENDUKUNG</div><div class="p-3 grid grid-cols-1 md:grid-cols-3 gap-6"><div><label for="pas_foto" class="form-label">Pas Foto 2x3 Berwarna</label><input type="file" id="pas_foto" name="pas_foto" class="form-input" required></div><div><label for="scan_ktp" class="form-label">Scan/Foto KTP</label><input type="file" id="scan_ktp" name="scan_ktp" class="form-input" required></div><div><label for="scan_sk" class="form-label">Scan/Foto SK Kepegawaian</label><input type="file" id="scan_sk" name="scan_sk" class="form-input" required></div></div></div>
                                    <div class="border-2 border-black"><div class="section-title">UNTUK KEPERLUAN KOPERASI</div><div class="p-3 text-xs space-y-3"><p>Catatan bagi Pengurus/Petugas:</p><div class="grid grid-cols-2 gap-x-8"><div class="space-y-2"><p class="font-bold">Diperiksa & Disetujui</p><div class="flex items-center gap-2"><label class="form-label w-24 shrink-0">Tanggal</label><div class="flex-grow border-b border-dotted border-black h-4"></div></div><div class="flex items-start gap-2"><label class="form-label w-24 shrink-0">Nama & Tanda Tangan</label><div class="flex-grow"><div class="w-full h-12"></div><div class="border-t border-dotted border-black text-center">(...............................................)</div></div></div></div><div class="space-y-2"><p class="font-bold">Diproses</p><div class="flex items-center gap-2"><label class="form-label w-24 shrink-0">Tanggal</label><div class="flex-grow border-b border-dotted border-black h-4"></div></div><div class="flex items-start gap-2"><label class="form-label w-24 shrink-0">Nama & Tanda Tangan</label><div class="flex-grow"><div class="w-full h-12"></div><div class="border-t border-dotted border-black text-center">(...............................................)</div></div></div></div></div><div class="flex items-center gap-2 pt-2"><label class="form-label">No. Anggota</label><div class="flex gap-1"><div class="w-6 h-6 border border-black bg-gray-100"></div><div class="w-6 h-6 border border-black bg-gray-100"></div><div class="w-6 h-6 border border-black bg-gray-100"></div><div class="w-6 h-6 border border-black bg-gray-100"></div><div class="w-6 h-6 border border-black bg-gray-100"></div><div class="w-6 h-6 border border-black bg-gray-100"></div><div class="w-6 h-6 border border-black bg-gray-100"></div><div class="w-6 h-6 border border-black bg-gray-100"></div></div></div></div></div>
                                    <div class="text-center pt-4"><button type="submit" class="bg-blue-700 text-white font-bold py-2 px-8 rounded hover:bg-blue-800 transition duration-300 shadow-md">KIRIM PENDAFTARAN</button></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
    @if (!Auth::user()->registration)
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Logika untuk Tanda Tangan
            const canvas = document.getElementById('signature-canvas');
            if (canvas) {
                function resizeCanvas() {
                    const ratio =  Math.max(window.devicePixelRatio || 1, 1);
                    canvas.width = canvas.offsetWidth * ratio;
                    canvas.height = canvas.offsetHeight * ratio;
                    canvas.getContext("2d").scale(ratio, ratio);
                }
                window.addEventListener("resize", resizeCanvas);
                resizeCanvas();
                const signaturePad = new SignaturePad(canvas, { backgroundColor: 'rgb(243, 244, 246)' });
                document.getElementById('clear-signature').addEventListener('click', () => signaturePad.clear());
                
                document.getElementById('registrationForm').addEventListener('submit', function(event) {
                    if (signaturePad.isEmpty()) {
                        alert("Mohon bubuhkan tanda tangan Anda pada kolom yang tersedia.");
                        event.preventDefault();
                    } else {
                        document.getElementById('signature-input').value = signaturePad.toDataURL('image/svg+xml');
                    }
                });
            }
            
            // Logika untuk Radio Button dengan Input Teks
            function setupRadioFocus(radioId, textId) {
                const radio = document.getElementById(radioId);
                const textInput = document.getElementById(textId);
                if(radio && textInput) {
                    textInput.addEventListener('focus', () => { radio.checked = true; });
                }
            }
            setupRadioFocus('mengenal_lain_radio', 'mengenal_lain_text');
            setupRadioFocus('pekerjaan_wiraswasta_radio', 'pekerjaan_wiraswasta_text');
            setupRadioFocus('pekerjaan_lain_radio', 'pekerjaan_lain_text');

            // Logika untuk Kotak-kotak Input
            function initCharBoxes(containerId, hiddenInputId) {
                const container = document.getElementById(containerId);
                if (!container) return;
                const hiddenInput = document.getElementById(hiddenInputId);
                const boxes = container.querySelectorAll('.char-box');

                function updateHiddenInput() {
                    hiddenInput.value = Array.from(boxes).map(box => box.value).join('');
                }

                container.addEventListener('input', (e) => {
                    const target = e.target;
                    if (target.matches('.char-box') && target.value.length === 1) {
                        const next = target.nextElementSibling;
                        if (next && next.matches('.char-box')) { next.focus(); }
                    }
                    updateHiddenInput();
                });

                container.addEventListener('keydown', (e) => {
                    const target = e.target;
                    if (e.key === 'Backspace' && target.matches('.char-box') && target.value === '') {
                        const prev = target.previousElementSibling;
                        if (prev && prev.matches('.char-box')) { prev.focus(); }
                    }
                });

                container.addEventListener('paste', (e) => {
                    e.preventDefault();
                    const pasteData = (e.clipboardData || window.clipboardData).getData('text');
                    const chars = pasteData.replace(/[^0-9]/g, '').split('');
                    let currentBox = e.target.closest('.char-box');
                    if (!currentBox) return; 
                    let currentIndex = Array.from(boxes).indexOf(currentBox);

                    chars.forEach((char, index) => {
                        let boxIndex = currentIndex + index;
                        if (boxIndex < boxes.length) {
                            boxes[boxIndex].value = char;
                            if (boxIndex < boxes.length - 1) {
                                boxes[boxIndex + 1].focus();
                            }
                        }
                    });
                    updateHiddenInput();
                });
            }
            initCharBoxes('telepon_rumah_boxes', 'telepon_rumah');
            initCharBoxes('no_hp_boxes', 'no_hp');
            initCharBoxes('no_ktp_boxes', 'no_ktp');
        });
    </script>
    @endif
    @endpush
</x-app-layout>