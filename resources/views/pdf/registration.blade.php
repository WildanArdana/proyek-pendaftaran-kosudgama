<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran Anggota</title>
    <style>
        @page {
            margin: 25px;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10.5px;
            color: #333;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
        }
        .header .logo {
            width: 60px;
            height: auto;
            position: absolute;
            top: 20px;
            left: 30px;
        }
        .header h4, .header h5 {
            margin: 0;
            padding: 0;
        }
        .header h4 {
            font-size: 14px;
            font-weight: bold;
        }
        .header h5 {
            font-size: 12px;
            font-weight: normal;
        }
        .header .subtitle {
            font-size: 9px;
            margin-top: 2px;
        }

        .section-title {
            background-color: #d3d3d3;
            color: #000;
            font-weight: bold;
            padding: 4px 8px;
            margin-top: 10px;
            margin-bottom: 8px;
            font-size: 11px;
            border-radius: 3px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            padding: 2px 4px;
            vertical-align: top;
        }
        .label {
            width: 150px;
        }
        .separator {
            width: 10px;
            text-align: center;
        }
        .value {
            border-bottom: 1px solid #999;
            font-weight: bold;
        }
        .value-full {
             width: 100%;
        }
        .checkbox-container {
            margin-top: 5px;
        }
        .checkbox {
            display: inline-block;
            width: 12px;
            height: 12px;
            border: 1px solid #333;
            margin-right: 5px;
            text-align: center;
            line-height: 12px;
            font-weight: bold;
        }

        .photo-box {
            width: 113px; /* 3cm */
            height: 151px; /* 4cm */
            border: 1px solid #333;
            text-align: center;
            position: absolute;
            right: 30px;
            top: 110px;
        }
         .photo-box img {
            width: 100%;
            height: 100%;
        }

        .footer-section {
            margin-top: 20px;
            border: 1px solid #000;
            padding: 10px;
        }
        .footer-section .title {
            font-weight: bold;
            text-align: center;
            font-size: 11px;
            margin-bottom: 8px;
        }
        .signature-area {
            margin-top: 15px;
            text-align: right;
        }
        .signature-area .signature-img {
            max-width: 150px;
            height: auto;
        }
        .signature-area .applicant-name {
            font-weight: bold;
            margin-top: 2px;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ public_path('images/logo.png') }}" alt="Logo" class="logo">
            <h5>FORMULIR APLIKASI KEANGGOTAAN</h5>
            <h4>KOPERASI KONSUMEN</h4>
            <h4>KOSUDGAMA DAYA GEMILANG</h4>
            <div class="subtitle">
                Bulaksumur A 14-15 RT/RW 020/003 CT Depok Sleman Yogyakarta 55281<br>
                Telp. (0274) 514310, 515714, 521123 | Website: www.kosudgama.org | E-Mail: kosudgama07@yahoo.com
            </div>
        </div>

        <div class="photo-box">
             @if($registration->path_pas_foto)
                <img src="{{ storage_path('app/public/' . $registration->path_pas_foto) }}" alt="Pas Foto">
            @endif
        </div>

        <div class="section-title">DATA PRIBADI</div>
        <table style="width: calc(100% - 140px);">
            <tr>
                <td class="label">Nama Lengkap</td>
                <td class="separator">:</td>
                <td class="value value-full">{{ $registration->nama_lengkap }}</td>
            </tr>
            <tr>
                <td class="label">Tempat & Tanggal Lahir</td>
                <td class="separator">:</td>
                <td class="value value-full">{{ $registration->tempat_lahir }}, {{ \Carbon\Carbon::parse($registration->tanggal_lahir)->format('d F Y') }}</td>
            </tr>
            <tr>
                <td class="label">Jenis Kelamin</td>
                <td class="separator">:</td>
                <td>
                    <div class="checkbox-container">
                        <span class="checkbox">{{ $registration->jenis_kelamin == 'Laki-laki' ? '✔' : '' }}</span> Laki-laki
                        <span class="checkbox" style="margin-left: 20px;">{{ $registration->jenis_kelamin == 'Perempuan' ? '✔' : '' }}</span> Perempuan
                    </div>
                </td>
            </tr>
        </table>

        <div class="section-title">DATA TEMPAT TINGGAL</div>
        <table>
            <tr>
                <td class="label">Alamat di KTP</td>
                <td class="separator">:</td>
                <td class="value" style="width: 55%;">{{ $registration->alamat_ktp }}</td>
                <td style="width: 60px; text-align: right;">Kode Pos:</td>
                <td class="value" style="width: 15%;">{{ $registration->kode_pos_ktp }}</td>
            </tr>
            <tr>
                <td class="label">Alamat Rumah</td>
                <td class="separator">:</td>
                <td class="value">{{ $registration->alamat_rumah }}</td>
                 <td style="width: 60px; text-align: right;">Kode Pos:</td>
                <td class="value">{{ $registration->kode_pos_rumah }}</td>
            </tr>
             <tr>
                <td class="label">Telepon / HP</td>
                <td class="separator">:</td>
                <td class="value">{{ $registration->telepon_rumah }} / {{ $registration->no_hp }}</td>
            </tr>
             <tr>
                <td class="label">No. KTP</td>
                <td class="separator">:</td>
                <td class="value">{{ $registration->no_ktp }}</td>
            </tr>
            <tr>
                <td class="label">E-Mail</td>
                <td class="separator">:</td>
                <td class="value">{{ $registration->email }}</td>
            </tr>
        </table>

        <div class="section-title">DATA PEKERJAAN</div>
        <table>
            <tr>
                <td class="label">Pekerjaan</td>
                <td class="separator">:</td>
                <td class="value">{{ $registration->pekerjaan }}</td>
            </tr>
            <tr>
                <td class="label">Nama Kantor/Instansi</td>
                <td class="separator">:</td>
                <td class="value">{{ $registration->nama_instansi }}</td>
            </tr>
             <tr>
                <td class="label">Alamat Kantor</td>
                <td class="separator">:</td>
                <td class="value" style="width: 55%;">{{ $registration->alamat_instansi }}</td>
                <td style="width: 60px; text-align: right;">Kode Pos:</td>
                <td class="value" style="width: 15%;">{{ $registration->kode_pos_instansi }}</td>
            </tr>
            <tr>
                <td class="label">Telepon</td>
                <td class="separator">:</td>
                <td class="value">{{ $registration->telp_instansi }}</td>
            </tr>
        </table>

        <div class="section-title">REFERENSI ANGGOTA (HARUS 2 ORANG)</div>
         <table>
            <tr>
                <td class="label">1. Nama</td>
                <td class="separator">:</td>
                <td class="value" style="width: 45%;">{{ $registration->nama_referensi_1 }}</td>
                <td style="padding-left: 20px; width: 100px;">No. Anggota:</td>
                <td class="value">{{ $registration->no_anggota_referensi_1 }}</td>
            </tr>
             <tr>
                <td class="label">2. Nama</td>
                <td class="separator">:</td>
                <td class="value">{{ $registration->nama_referensi_2 }}</td>
                <td style="padding-left: 20px;">No. Anggota:</td>
                <td class="value">{{ $registration->no_anggota_referensi_2 }}</td>
            </tr>
        </table>


        <div class="footer-section">
            <div class="title">PERNYATAAN DAN KUASA</div>
            <p style="font-size: 9px; text-align: justify; line-height: 1.4;">
                Dengan mengetahui, memahami dan menyetujui segala persyaratan yang diberikan, kami selaku calon anggota mengajukan permohonan untuk menjadi anggota KOSUDGAMA. Apabila di kemudian hari terdapat hambatan dalam pemenuhan kewajiban dari saya selaku anggota, maka dengan ini memberikan kuasa kepada KOSUDGAMA untuk mengambil segala tindakan yang diperlukan sesuai dengan peraturan yang berlaku.
            </p>

            <div class="signature-area">
                Yogyakarta, {{ \Carbon\Carbon::now()->format('d F Y') }}<br>
                Pemohon,
                <div style="height: 50px;">
                    @if($registration->tanda_tangan)
                        <img src="{{ $registration->tanda_tangan }}" alt="Tanda Tangan" class="signature-img">
                    @endif
                </div>
                <div class="applicant-name">( {{ $registration->nama_lengkap }} )</div>
            </div>
        </div>
    </div>
</body>
</html>