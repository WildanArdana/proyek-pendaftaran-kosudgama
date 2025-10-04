<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Formulir Pendaftaran - {{ $registration->nama_lengkap }}</title>
    <style>
        @page { margin: 20px 25px; }
        body { font-family: 'Arial', sans-serif; font-size: 8px; color: #000; }
        .watermark { position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-45deg); opacity: 0.07; font-size: 100px; font-weight: bold; color: #000; z-index: -1000; }
        
        .header-table { width: 100%; border: none; margin-bottom: 5px; }
        .header-table td { border: none; vertical-align: top; }
        .header-title { font-family: 'Times New Roman', serif; font-weight: bold; }

        .section-title {
            background-color: #008c4b; color: white; font-weight: bold;
            padding: 3px; font-size: 10px; text-align: center;
            border: 1px solid #000;
        }
        .main-border { border: 2px solid #000; margin-top: 5px; }
        .section-content { padding: 5px 8px; }

        .form-label { white-space: nowrap; }
        .value-box { border: 1px solid #000; padding: 2px 4px; height: 14px; }

        .check-item { display: inline-block; margin-right: 10px; white-space: nowrap; }
        .checkbox {
            display: inline-block; width: 10px; height: 10px;
            border: 1px solid #000; text-align: center;
            line-height: 10px; font-weight: bold; vertical-align: middle;
        }
        
        .char-box-container { display: inline-block; }
        .char-box {
            display: inline-block; width: 12px; height: 14px;
            border: 1px solid #000; text-align: center;
            margin-right: 1px; line-height: 14px; font-weight: bold;
        }
        
        .dotted-line { border-bottom: 1px dotted #000; height: 14px; }
    </style>
</head>
<body>
    <div class="watermark">KOSUDGAMA DAYA GEMILANG</div>

    {{-- HEADER --}}
    <table class="header-table">
        <tr>
            <td style="width: 70%;">
                <h1 class="header-title" style="font-size: 28px; margin: 0;">FORMULIR</h1>
                <p style="font-size: 14px; margin: 0; font-weight: bold;">Aplikasi Keanggotaan</p>
            </td>
            <td style="width: 30%; text-align: right;">
                <img src="{{ public_path('images/logo.png') }}" alt="Logo" style="height: 40px; width: auto; margin-bottom: 5px;">
                <p style="font-size: 8px; margin: 0; line-height: 1.2;">
                    <span class="header-title" style="font-size: 10px;">KOPERASI KONSUMEN KOSUDGAMA DAYA GEMILANG</span><br>
                    Bulaksumur A 14-15, Caturtunggal, Depok, Sleman, Yogyakarta 55281<br>
                    Telp. (0274) 514310, 515714, 521123 | Website: www.kosudgama.org
                </p>
            </td>
        </tr>
    </table>
    <div style="border-bottom: 3px solid #000; margin-bottom: 5px;"></div>

    {{-- PERSYARATAN --}}
    <div class="main-border">
        <div class="section-title">PERSYARATAN</div>
        <div class="section-content" style="font-size: 8.5px;">
            <ol style="margin: 0; padding-left: 15px; columns: 2; -webkit-columns: 2; -moz-columns: 2; gap: 20px;">
                <li>Bersedia memenuhi Anggaran Dasar, Anggaran Rumah Tangga, Kode Etik dan segala peraturan yang berlaku di KOSUDGAMA.</li>
                <li>Berusia maksimal 60 tahun pada saat pendaftaran.</li>
                <li>Membayar Simpanan Pokok sebesar Rp100.000,- (seratus ribu rupiah).</li>
                <li>Sanggup membayar Simpanan Wajib sebesar Rp 240.000,- per tahun dibayar dimuka.</li>
                <li>Menyerahkan 2 (dua) lembar pas foto berwarna asli terbaru ukuran 2 x 3 cm (bukan croping, hasil scan).</li>
                <li>Menyerahkan 1 (satu) lembar fotocopy identitas diri yang masih berlaku dan fotocopy SK Kepegawaian terakhir.</li>
                <li>Membayar Modal Penyetaraan Anggota yang besarnya ditentukan oleh Pengurus KOSUDGAMA.</li>
                <li>Tidak mengundurkan diri sebagai anggota selama masa 1 (satu) tahun.</li>
            </ol>
        </div>
    </div>

    @php
        $fasilitasOptions = ["Simpanan(SIMANIS & Deposito)", "Kredit (Uang & Barang)", "Dana Simpati", "Diskon Pembelian Obat", "KIPO", "Reservasi Tiket", "Pembuatan/Perpanjangan SIM/STNK", "Pembuatan Paspor", "Swalayan KOSUDGAMA"];
        $infoOptions = ["Rekan sejawat", "Saudara", "Suami/Istri", "Media cetak"];
        $pekerjaanOptions = ["Pegawai (tetap/honorer)*", "Dosen (tetap/honorer)*", "Ibu Rumah Tangga"];

        $fasilitasDipilih = $registration->fasilitas_menarik ?? [];
        $infoDari = $registration->mengenal_dari ?? '';
        $pekerjaanDipilih = $registration->pekerjaan ?? '';
    @endphp

    {{-- DATA PRIBADI --}}
    <div class="main-border">
        <div class="section-title">DATA PRIBADI</div>
        <div class="section-content">
            <table style="width: 100%; border:none;">
                <tr>
                    <td class="form-label" style="width: 150px;">Nama (20 digit dalam kartu anggota)</td>
                    <td class="value-box">{{ $registration->nama_lengkap }}</td>
                </tr>
                <tr>
                    <td class="form-label">Tempat & Tanggal lahir</td>
                    <td class="value-box" style="position: relative;">
                        {{ $registration->tempat_lahir }}, {{ \Carbon\Carbon::parse($registration->tanggal_lahir)->format('d F Y') }}
                        <span style="position: absolute; right: 5px; top: 2px;">
                            Jenis Kelamin: 
                            <span class="check-item"><span class="checkbox">{{ $registration->jenis_kelamin == 'Laki-laki' ? '✔' : '' }}</span> Laki-laki</span>
                            <span class="check-item"><span class="checkbox">{{ $registration->jenis_kelamin == 'Perempuan' ? '✔' : '' }}</span> Perempuan</span>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td class="form-label">Mengenal KOSUDGAMA dari</td>
                    <td>
                        @foreach($infoOptions as $option)
                            <span class="check-item"><span class="checkbox">{{ $infoDari == $option ? '✔' : '' }}</span> {{ $option }}</span>
                        @endforeach
                        <span class="check-item"><span class="checkbox">{{ !in_array($infoDari, $infoOptions) && !empty($infoDari) ? '✔' : '' }}</span> Lain-lain (sebutkan: <span style="text-decoration: underline;">{{ !in_array($infoDari, $infoOptions) && !empty($infoDari) ? $infoDari : '...' }}</span>)</span>
                    </td>
                </tr>
                 <tr>
                    <td class="form-label" style="vertical-align: middle;">Fasilitas yang menarik...</td>
                    <td>
                        @foreach(array_chunk($fasilitasOptions, 5) as $chunk)
                            <div style="margin-bottom: 2px;">
                            @foreach($chunk as $option)
                                <span class="check-item"><span class="checkbox">{{ in_array($option, $fasilitasDipilih) ? '✔' : '' }}</span> {{ $option }}</span>
                            @endforeach
                            </div>
                        @endforeach
                    </td>
                </tr>
            </table>
        </div>
    </div>

    {{-- DATA TEMPAT TINGGAL --}}
    <div class="main-border">
        <div class="section-title">DATA TEMPAT TINGGAL</div>
        <div class="section-content">
            <table style="border:none;">
                 <tr>
                    <td class="form-label" style="width: 100px;">Alamat di KTP</td>
                    <td class="value-box">{{ $registration->alamat_ktp }}</td>
                    <td class="form-label" style="width: 50px; text-align:right; padding-right: 5px;">Kode Pos</td>
                    <td class="value-box" style="width: 80px;">{{ $registration->kode_pos_ktp }}</td>
                </tr>
                <tr>
                    <td class="form-label">Alamat rumah</td>
                    <td class="value-box">{{ $registration->alamat_rumah }}</td>
                    <td class="form-label" style="width: 50px; text-align:right; padding-right: 5px;">Kode Pos</td>
                    <td class="value-box" style="width: 80px;">{{ $registration->kode_pos_rumah }}</td>
                </tr>
            </table>
             <table style="margin-top: 5px; border:none;">
                <tr>
                    <td class="form-label" style="width: 100px;">Telepon</td>
                    <td style="width: 320px;">
                        <div class="char-box-container">
                            @foreach(str_split(str_pad($registration->telepon_rumah, 12, ' ', STR_PAD_RIGHT)) as $char)
                                <span class="char-box">{{ $char }}</span>
                            @endforeach
                        </div>
                    </td>
                    <td class="form-label" style="width: 65px; text-align:right;">Hand Phone</td>
                    <td>
                        <div class="char-box-container">
                            @foreach(str_split(str_pad($registration->no_hp, 13, ' ', STR_PAD_RIGHT)) as $char)
                                <span class="char-box">{{ $char }}</span>
                            @endforeach
                        </div>
                    </td>
                </tr>
                 <tr>
                    <td class="form-label">Kartu Identitas</td>
                    <td>
                        KTP No.
                        <div class="char-box-container" style="margin-left: 5px;">
                            @foreach(str_split(str_pad($registration->no_ktp, 16, ' ', STR_PAD_RIGHT)) as $char)
                                <span class="char-box">{{ $char }}</span>
                            @endforeach
                        </div>
                    </td>
                    <td class="form-label" style="text-align:right;">E-Mail</td>
                    <td class="value-box">{{ $registration->email }}</td>
                </tr>
            </table>
        </div>
    </div>
    
    {{-- Sisa formulir di bawah ini --}}
    <div class="main-border">
        <div class="section-title">DATA PEKERJAAN</div>
        <div class="section-content">
            <table style="border:none;">
                <tr>
                    <td class="form-label" style="width:150px;">Pekerjaan (*Coret salah satu)</td>
                    <td>
                        @foreach($pekerjaanOptions as $option)
                        <span class="check-item"><span class="checkbox">{{ Str::startsWith($pekerjaanDipilih, $option) ? '✔' : '' }}</span> {{ $option }}</span>
                        @endforeach
                        <br>
                        <span class="check-item"><span class="checkbox">{{ Str::startsWith($pekerjaanDipilih, 'Wiraswasta') ? '✔' : '' }}</span> Wiraswasta ( <span style="text-decoration: underline;">{{ Str::startsWith($pekerjaanDipilih, 'Wiraswasta') ? Str::after($pekerjaanDipilih, 'Wiraswasta: ') : '...' }}</span> )</span>
                        <span class="check-item"><span class="checkbox">{{ Str::startsWith($pekerjaanDipilih, 'Lain-lain') ? '✔' : '' }}</span> Lain-lain (sebutkan: <span style="text-decoration: underline;">{{ Str::startsWith($pekerjaanDipilih, 'Lain-lain') ? Str::after($pekerjaanDipilih, 'Lain-lain: ') : '...' }}</span> )</span>
                    </td>
                </tr>
                <tr>
                    <td class="form-label">Nama Kantor/Instansi</td>
                    <td class="value-box">{{ $registration->nama_instansi }}</td>
                </tr>
                <tr>
                    <td class="form-label">Alamat Kantor</td>
                    <td class="value-box">{{ $registration->alamat_instansi }}</td>
                </tr>
                 <tr>
                    <td class="form-label">Telepon</td>
                    <td class="value-box" style="position:relative;">
                        {{ $registration->telp_instansi }}
                        <span style="position:absolute; right: 5px; top: 2px;">
                            Kode Pos: {{ $registration->kode_pos_instansi }}
                        </span>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <table style="width: 100%; border: none; page-break-inside: avoid; margin-top:5px;">
        <tr>
            <td style="width: 50%; padding: 0; vertical-align: top; border: none; padding-right: 2px;">
                 <div class="main-border">
                    <div class="section-title">REFERENSI ANGGOTA (HARUS 2 ORANG)</div>
                    <div class="section-content" style="font-size: 7.5px;">
                       <p style="font-style: italic; margin: 0 0 5px 0;">Menyatakan mengetahui dan mengenal dengan baik calon anggota... kami ikut bertanggung jawab secara penuh.</p>
                       <table style="border:none;">
                           <tr>
                               <td class="form-label" style="width:60px;">1. Nama</td>
                               <td class="dotted-line">{{ $registration->nama_referensi_1 }}</td>
                           </tr>
                           <tr>
                               <td class="form-label">No. Anggota</td>
                               <td class="dotted-line">{{ $registration->no_anggota_referensi_1 }}</td>
                           </tr>
                           <tr>
                               <td colspan="2" style="text-align:center; padding-top: 20px; font-size:8px;">Pemberi Referensi 1: (.........................)</td>
                           </tr>
                       </table>
                       <table style="border:none; margin-top:10px;">
                           <tr>
                               <td class="form-label" style="width:60px;">2. Nama</td>
                               <td class="dotted-line">{{ $registration->nama_referensi_2 }}</td>
                           </tr>
                           <tr>
                               <td class="form-label">No. Anggota</td>
                               <td class="dotted-line">{{ $registration->no_anggota_referensi_2 }}</td>
                           </tr>
                           <tr>
                               <td colspan="2" style="text-align:center; padding-top: 20px; font-size:8px;">Pemberi Referensi 2: (.........................)</td>
                           </tr>
                       </table>
                    </div>
                </div>
            </td>
            <td style="width: 50%; padding: 0; vertical-align: top; border: none; padding-left: 2px;">
                <div class="main-border" style="height:100%;">
                    <div class="section-title">PERNYATAAN DAN KUASA</div>
                    <div class="section-content">
                        <p style="font-size: 8px; font-style: italic; text-align: justify;">"Dengan mengetahui, memahami dan menyetujui segala persyaratan yang diberikan, kami selaku calon anggota mengajukan permohonan untuk menjadi anggota KOSUDGAMA. Apabila di kemudian hari terdapat hambatan dalam pemenuhan kewajiban dari saya selaku anggota, maka dengan ini memberikan kuasa kepada KOSUDGAMA untuk mengambil segala tindakan yang diperlukan sesuai dengan peraturan yang berlaku."</p>
                        <div style="text-align: center; margin-top: 20px;">
                            Yogyakarta, {{ $registration->created_at->translatedFormat('d F Y') }}
                            <br><br>
                            <img src="{{ $registration->tanda_tangan }}" alt="Tanda Tangan" style="height: 40px; width: auto; margin: 0 auto;">
                            <br>
                            ( {{ $registration->user->name }} )
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>

