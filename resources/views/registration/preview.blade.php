<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Preview Formulir Pendaftaran
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p class="font-bold">Pendaftaran Berhasil Dikirim!</p>
                <p>Silakan periksa kembali data Anda di bawah ini. Anda dapat mengunduh salinan formulir ini sebagai arsip.</p>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Data Formulir Anda</h3>
                        <div>
                            <a href="{{ route('registration.download', $registration->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">Download PDF</a>
                            <a href="{{ route('dashboard') }}" class="ml-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">Kembali ke Dashboard</a>
                        </div>
                    </div>

                    {{-- Menampilkan PDF sebagai Iframe --}}
                    <iframe src="{{ route('registration.download', $registration->id) }}" width="100%" height="800px" class="border"></iframe>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>