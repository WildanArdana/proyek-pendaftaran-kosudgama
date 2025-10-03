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
    <body class="antialiased bg-gray-100">
        <div class="relative min-h-screen flex flex-col items-center justify-center">
            @if (Route::has('login'))
                <div class="fixed top-0 right-0 p-6 text-right z-10">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="max-w-lg w-full text-center p-6">
                <img src="https://i.ibb.co/hK3aL7v/logo-kosudgama.png" alt="Logo KOSUDGAMA" class="h-32 mx-auto mb-4">
                <h1 class="text-3xl font-bold text-gray-800">Selamat Datang di Sistem Pendaftaran Online</h1>
                <h2 class="text-2xl font-semibold text-gray-700">KOPERASI KONSUMEN KOSUDGAMA DAYA GEMILANG</h2>
                <p class="mt-4 text-gray-600">Untuk memulai proses pendaftaran keanggotaan, silakan buat akun terlebih dahulu atau masuk jika Anda sudah memiliki akun.</p>
                <div class="mt-8 flex justify-center gap-4">
                     <a href="{{ route('register') }}" class="inline-block bg-green-600 text-white font-bold py-3 px-8 rounded-lg hover:bg-green-700 transition text-lg">Buat Akun Baru</a>
                </div>
            </div>
        </div>
    </body>
</html>