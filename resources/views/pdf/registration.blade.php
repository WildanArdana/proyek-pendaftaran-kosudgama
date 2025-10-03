<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Formulir Pendaftaran - {{ $registration->nama_lengkap }}</title>
    <style>
        @page { margin: 25px; }
        body { font-family: 'Arial', sans-serif; font-size: 10px; }
        .watermark { position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-45deg); opacity: 0.08; font-size: 80px; font-weight: bold; color: #000; z-index: -1000; }
        .header, .footer { width: 100%; text-align: center; }
        .section-title { background-color: #008c4b; color: white; font-weight: bold; padding: 2px 8px; font-size: 11px; text-align: center; margin-top: 10px;}
        table { width: 100%; border-collapse: collapse; margin-top: 5px; }
        td, th { padding: 4px; vertical-align: top; border: 1px solid #ccc; text-align: left; }
        .label { font-weight: bold; width: 25%; }
        .data-group { page-break-inside: avoid; }
    </style>
</head>
<body>
    <div class="watermark">KOSUDGAMA DAYA GEMILANG</div>

    <table style="width: 100%; border: none; margin-bottom: 10px;">
        <tr style="border: none;">
            <td style="width: 20%; border: none; text-align: center;">
                <img src="{{ public_path('logo.png') }}" alt="Logo" style="width: 80px; height: auto;">
            </td>
            <td style="width: 80%; border: none; text-align: right; vertical-align: middle;">
                <h1 style="font-family: 'Times New Roman', serif; font-size: 16px; margin: 0;">KOPERASI KONSUMEN KOSUDGAMA DAYA GEMILANG</h1>
                <p style="font-size: 8px; margin: 2px 0;">Bulaksumur A 14-15, Caturtunggal, Depok, Sleman, Yogyakarta 55281 | Telp. (0274) 514310</p>
            </td>
        </tr>
    </table>

    <div class="section-title" style="margin-top: 0;">DATA PRIBADI</div>
    <table>
        <tr><td class="label">Nama Lengkap</td><td>{{ $registration->nama_lengkap }}</td></tr>
        <tr><td class="label">Tempat & Tgl Lahir</td><td>{{ $registration->tempat_lahir }}, {{ \Carbon\Carbon::parse($registration->tanggal_lahir)->format('d F Y') }}</td></tr>
        <tr><td class="label">Jenis Kelamin</td><td>{{ $registration->jenis_kelamin }}</td></tr>
    </table>

    <div class="section-title">DATA TEMPAT TINGGAL</div>
    <table>
        <tr><td class="label">Alamat KTP</td><td>{{ $registration->alamat_ktp }} - Kode Pos: {{ $registration->kode_pos_ktp }}</td></tr>
        <tr><td class="label">Alamat Rumah</td><td>{{ $registration->alamat_rumah }} - Kode Pos: {{ $registration->kode_pos_rumah }}</td></tr>
        <tr><td class="label">Telepon / HP</td><td>{{ $registration->telepon_rumah }} / {{ $registration->no_hp }}</td></tr>
        <tr><td class="label">No. KTP</td><td>{{ $registration->no_ktp }}</td></tr>
        <tr><td class="label">Email</td><td>{{ $registration->email }}</td></tr>
    </table>

    <div class="section-title">DATA PEKERJAAN</div>
    <table>
        <tr><td class="label">Pekerjaan</td><td>{{ $registration->pekerjaan }}</td></tr>
        <tr><td class="label">Nama Instansi</td><td>{{ $registration->nama_instansi }}</td></tr>
        <tr><td class="label">Alamat Instansi</td><td>{{ $registration->alamat_instansi }}</td></tr>
    </table>

    <div class="section-title">PERNYATAAN & TANDA TANGAN</div>
    <table style="border: 1px solid #ccc;">
        <tr>
            <td style="width: 60%; font-size: 8px; font-style: italic; border-right: 1px solid #ccc;">"Dengan mengetahui, memahami dan menyetujui segala persyaratan yang diberikan, kami selaku calon anggota mengajukan permohonan untuk menjadi anggota KOSUDGAMA..."</td>
            <td style="width: 40%; text-align: center;">
                <p>Yogyakarta, {{ $registration->created_at->format('d F Y') }}</p>
                <img src="{{ $registration->tanda_tangan }}" alt="Tanda Tangan" style="width: 150px; height: auto; margin: 5px auto;">
                <p style="font-weight: bold;">( {{ Auth::user()->name }} )</p>
            </td>
        </tr>
    </table>
</body>
</html>