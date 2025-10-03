<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Preview Formulir Pendaftaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h3 class="text-lg font-bold mb-4">Pastikan data Anda sudah benar sebelum mengunduh PDF.</h3>

                    <div class="mb-6">
                        <h4 class="font-bold border-b pb-2 mb-2">Data Pribadi</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <p><strong>Nama Lengkap:</strong> {{ $registration->nama_lengkap }}</p>
                            <p><strong>Tempat & Tanggal Lahir:</strong> {{ $registration->tempat_lahir }}, {{ \Carbon\Carbon::parse($registration->tanggal_lahir)->format('d F Y') }}</p>
                            <p><strong>Jenis Kelamin:</strong> {{ $registration->jenis_kelamin }}</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h4 class="font-bold border-b pb-2 mb-2">Informasi Tambahan</h4>
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <p class="font-semibold">Fasilitas yang Paling Menarik:</p>
                                @if(!empty($registration->fasilitas_menarik))
                                    <ul class="list-disc list-inside">
                                        @foreach($registration->fasilitas_menarik as $fasilitas)
                                            <li>{{ $fasilitas }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>-</p>
                                @endif
                            </div>
                            <p><strong>Mendapat Informasi KOSUDGAMA dari:</strong> {{ $registration->mengenal_dari ?: '-' }}</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h4 class="font-bold border-b pb-2 mb-2">Data Tempat Tinggal</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <p><strong>Alamat KTP:</strong> {{ $registration->alamat_ktp }} (Kode Pos: {{ $registration->kode_pos_ktp }})</p>
                            <p><strong>Alamat Rumah:</strong> {{ $registration->alamat_rumah }} (Kode Pos: {{ $registration->kode_pos_rumah }})</p>
                            <p><strong>No. Telepon Rumah:</strong> {{ $registration->telepon_rumah ?: '-' }}</p>
                            <p><strong>No. HP:</strong> {{ $registration->no_hp }}</p>
                            <p><strong>No. KTP:</strong> {{ $registration->no_ktp }}</p>
                            <p><strong>Email:</strong> {{ $registration->email }}</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h4 class="font-bold border-b pb-2 mb-2">Data Pekerjaan</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <p><strong>Pekerjaan:</strong> {{ $registration->pekerjaan }}</p>
                            <p><strong>Nama Instansi:</strong> {{ $registration->nama_instansi }}</p>
                            <p><strong>Alamat Instansi:</strong> {{ $registration->alamat_instansi }} (Kode Pos: {{ $registration->kode_pos_instansi }})</p>
                            <p><strong>Telepon Instansi:</strong> {{ $registration->telp_instansi }}</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h4 class="font-bold border-b pb-2 mb-2">Referensi Anggota</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <p><strong>Referensi 1:</strong> {{ $registration->nama_referensi_1 }} (No. Anggota: {{ $registration->no_anggota_referensi_1 }})</p>
                            <p><strong>Referensi 2:</strong> {{ $registration->nama_referensi_2 }} (No. Anggota: {{ $registration->no_anggota_referensi_2 }})</p>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <h4 class="font-bold border-b pb-2 mb-2">Tanda Tangan</h4>
                        @if($registration->tanda_tangan)
                            <img src="{{ $registration->tanda_tangan }}" alt="Tanda Tangan" class="border p-2">
                        @endif
                    </div>


                    <div class="mt-8 flex justify-end">
                        <a href="{{ route('registration.download', $registration->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Unduh Formulir (PDF)
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>