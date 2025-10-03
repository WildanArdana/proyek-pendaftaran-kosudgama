{{-- resources/views/dashboard.blade.php --}}

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
                            
                            {{-- ====================================================== --}}
                            {{-- BAGIAN YANG DIPERBARUI --}}
                            {{-- ====================================================== --}}
                            @elseif($registration->status == 'Perlu Revisi' || $registration->status == 'Ditolak')
                                <p class="text-lg font-bold text-red-600">{{ $registration->status }}</p>
                                <div class="mt-2 p-3 bg-red-50 border border-red-200 rounded-md">
                                    <h5 class="font-semibold text-red-800">Catatan dari Admin:</h5>
                                    <p class="text-sm text-red-700 whitespace-pre-line">{{ $registration->rejection_reason }}</p>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('registration.edit', $registration->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600">
                                        Perbaiki Pendaftaran
                                    </a>
                                </div>
                            {{-- ====================================================== --}}
                            {{-- AKHIR BAGIAN YANG DIPERBARUI --}}
                            {{-- ====================================================== --}}

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
                        
                        @include('registration.form-content')

                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
    {{-- SCRIPT HANYA Dijalankan JIKA FORMULIR TAMPIL --}}
    @if (!Auth::user()->registration)
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
            function initCharBoxes(containerId, hiddenInputId) {
                const container = document.getElementById(containerId);
                if (!container) return;
                const hiddenInput = document.getElementById(hiddenInputId);
                const boxes = container.querySelectorAll('.char-box');
                function populateBoxes() {
                    const value = hiddenInput.value.split('');
                    boxes.forEach((box, index) => { box.value = value[index] || ''; });
                }
                function updateHiddenInput() {
                    let value = '';
                    boxes.forEach(box => { value += box.value; });
                    hiddenInput.value = value;
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
                    const chars = pasteData.split('');
                    boxes.forEach((box, index) => {
                        if (chars[index]) {
                            box.value = chars[index];
                            if (index < boxes.length - 1) { boxes[index + 1].focus(); }
                        }
                    });
                    updateHiddenInput();
                });
                populateBoxes();
            }
            initCharBoxes('telepon_rumah_boxes', 'telepon_rumah');
            initCharBoxes('no_hp_boxes', 'no_hp');
            initCharBoxes('no_ktp_boxes', 'no_ktp');
        });
    </script>
    @endif
    @endpush
</x-app-layout>