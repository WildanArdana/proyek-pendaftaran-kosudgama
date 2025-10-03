<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Perbaiki Formulir Pendaftaran
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            {{-- Menampilkan catatan dari admin di bagian atas --}}
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p class="font-bold">Pendaftaran Anda Perlu Diperbaiki</p>
                <p>Berikut adalah catatan dari admin:</p>
                <p class="mt-2 whitespace-pre-line">{{ $registration->rejection_reason }}</p>
            </div>
            
            {{-- Di sini kita include formulir yang sama, tapi mengirimkan data $registration --}}
            {{-- Ini akan otomatis mengisi semua kolom --}}
            @include('registration.form-content', ['registration' => $registration])
        </div>
    </div>
</x-app-layout>