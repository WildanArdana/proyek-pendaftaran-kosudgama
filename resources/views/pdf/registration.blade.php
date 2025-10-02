<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Formulir Pendaftaran - {{ $registration->nama_lengkap }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 12px; }
        .watermark { position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-45deg); opacity: 0.1; font-size: 100px; font-weight: bold; color: #888; z-index: -1000; }
        .header { text-align: center; margin-bottom: 20px; }
        .section-title { font-size: 14px; font-weight: bold; border-bottom: 1px solid #000; padding-bottom: 5px; margin-top: 20px; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 5px; vertical-align: top; }
        .label { font-weight: bold; width: 30%; }
    </style>
</head>
<body>
    <div class="watermark">KOSUDGAMA</div>
    
    <div class="header">
        <h1>FORMULIR APLIKASI KEANGGOTAAN</h1>
        <h2>KOPERASI KONSUMEN KOSUDGAMA DAYA GEMILANG</h2>
    </div>

    <div class="section-title">DATA PRIBADI</div>
    <table>
        <tr><td class="label">Nama Lengkap</td><td>: {{ $registration->nama_lengkap }}</td></tr>
        <tr><td class="label">Jenis Kelamin</td><td>: {{ $registration->jenis_kelamin }}</td></tr>
        <tr><td class="label">Tempat & Tanggal Lahir</td><td>: {{ $registration->tempat_lahir }}, {{ \Carbon\Carbon::parse($registration->tanggal_lahir)->format('d F Y') }}</td></tr>
    </table>

    <div class="section-title">DATA TEMPAT TINGGAL</div>
     <table>
        <tr><td class="label">Alamat KTP</td><td>: {{ $registration->alamat_ktp }}</td></tr>
        <tr><td class="label">No. KTP</td><td>: {{ $registration->no_ktp }}</td></tr>
        <tr><td class="label">No. Handphone</td><td>: {{ $registration->no_hp }}</td></tr>
        <tr><td class="label">Email</td><td>: {{ $registration->email }}</td></tr>
    </table>
    
     <div class="section-title">PERNYATAAN DAN TANDA TANGAN</div>
     <p>Tanda Tangan Pemohon:</p>
     <img src="{{ $registration->tanda_tangan }}" alt="Tanda Tangan" style="width: 200px; height: auto;">
</body>
</html>