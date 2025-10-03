<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Pendaftaran Anggota KOSUDGAMA</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    </head>
    <body class="antialiased bg-gray-50">
        <div class="relative min-h-screen flex flex-col items-center justify-center text-center px-6">
            
            {{-- KONTEN UTAMA DI TENGAH --}}
            <div class="max-w-2xl w-full">
                
                {{-- Logo --}}
                <img src="{{ asset('images/logo.png') }}" alt="Logo KOSUDGAMA" class="h-32 mx-auto mb-6">
                
                {{-- Judul --}}
                <h1 class="text-4xl font-bold text-gray-800 tracking-tight">
                    Selamat Datang di Sistem Pendaftaran Online
                </h1>
                <h2 class="text-2xl font-semibold text-green-700 mt-1">
                    KOPERASI KONSUMEN KOSUDGAMA DAYA GEMILANG
                </h2>
                
                {{-- Deskripsi --}}
                <p class="mt-4 text-lg text-gray-600">
                    Untuk memulai proses pendaftaran keanggotaan, silakan buat akun baru atau masuk jika Anda sudah memiliki akun.
                </p>
                
                {{-- Tombol Aksi --}}
                <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                     <a href="{{ route('register') }}" class="w-full sm:w-auto inline-block bg-green-600 text-white font-bold py-3 px-10 rounded-lg text-lg hover:bg-green-700 transition duration-300 shadow-lg">
                        Daftar Akun Baru
                     </a>
                     <a href="{{ route('login') }}" class="w-full sm:w-auto inline-block bg-white text-gray-700 font-bold py-3 px-10 rounded-lg text-lg hover:bg-gray-100 transition duration-300 border border-gray-300 shadow-lg">
                        Masuk (Login)
                     </a>
                </div>

            </div>

             {{-- Footer --}}
            <div class="absolute bottom-6 text-sm text-gray-500">
                &copy; {{ date('Y') }} KOSUDGAMA DAYA GEMILANG. All rights reserved.
            </div>
        </div>
    </body>
</html>