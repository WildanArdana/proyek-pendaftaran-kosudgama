<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RegistrationResource\Pages;
use App\Models\Registration;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Support\Facades\Storage;

class RegistrationResource extends Resource
{
    protected static ?string $model = Registration::class;
    protected static ?string $navigationIcon = 'heroicon-o-identification';
    protected static ?string $navigationLabel = 'Pendaftar Anggota';
    protected static ?string $modelLabel = 'Pendaftar Baru';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('status')
                    ->options([
                        'Menunggu Verifikasi' => 'Menunggu Verifikasi',
                        'Perlu Revisi' => 'Perlu Revisi',
                        'Disetujui' => 'Disetujui',
                        'Ditolak' => 'Ditolak',
                    ])
                    ->required()
                    ->live(),

                Forms\Components\Textarea::make('rejection_reason')
                    ->label('Alasan Penolakan / Catatan Revisi')
                    ->required()
                    ->visible(fn (Forms\Get $get): bool => in_array($get('status'), ['Perlu Revisi', 'Ditolak'])),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_lengkap')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('user.name')->label('Nama Akun')->searchable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->label('Tanggal Daftar'),
                Tables\Columns\TextColumn::make('status')->badge()->color(fn (string $state): string => match ($state) {
                    'Menunggu Verifikasi' => 'warning', 'Perlu Revisi' => 'danger', 'Disetujui' => 'success', 'Ditolak' => 'danger',
                }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('Lihat Detail'),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('downloadForm')->label('Download PDF')->icon('heroicon-o-arrow-down-tray')->url(fn (Registration $record): string => route('registration.download', ['id' => $record->id]))->openUrlInNewTab(),
            ]);
    }
    
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Status Pendaftaran')
                    ->schema([
                        Infolists\Components\TextEntry::make('status')->badge()->color(fn (string $state): string => match ($state) {
                            'Menunggu Verifikasi' => 'warning', 'Perlu Revisi' => 'danger', 'Disetujui' => 'success', 'Ditolak' => 'danger',
                        }),
                        Infolists\Components\TextEntry::make('rejection_reason')
                            ->label('Catatan dari Admin')
                            ->visible(fn (Registration $record): bool => !empty($record->rejection_reason)),
                    ]),

                Infolists\Components\Section::make('Data Pribadi')
                    ->schema([
                        Infolists\Components\TextEntry::make('nama_lengkap'),
                        Infolists\Components\TextEntry::make('tempat_lahir'),
                        Infolists\Components\TextEntry::make('tanggal_lahir')->date('d F Y'),
                        Infolists\Components\TextEntry::make('jenis_kelamin'),
                    ])->columns(2),
                
                Infolists\Components\Section::make('Data Tempat Tinggal & Kontak')
                    ->schema([
                        Infolists\Components\TextEntry::make('alamat_ktp')->columnSpanFull(),
                        Infolists\Components\TextEntry::make('alamat_rumah')->columnSpanFull(),
                        Infolists\Components\TextEntry::make('telepon_rumah'),
                        Infolists\Components\TextEntry::make('no_hp')->label('No. Handphone'),
                        Infolists\Components\TextEntry::make('no_ktp')->label('No. KTP'),
                        Infolists\Components\TextEntry::make('email'),
                    ])->columns(2),

                Infolists\Components\Section::make('Data Pekerjaan')
                    ->schema([
                        Infolists\Components\TextEntry::make('pekerjaan'),
                        Infolists\Components\TextEntry::make('nama_instansi'),
                        Infolists\Components\TextEntry::make('alamat_instansi')->columnSpanFull(),
                        Infolists\Components\TextEntry::make('telp_instansi')->label('Telepon Instansi'),
                        Infolists\Components\TextEntry::make('kode_pos_instansi')->label('Kode Pos Instansi'),
                    ])->columns(2),

                Infolists\Components\Section::make('Informasi Tambahan')
                    ->schema([
                        Infolists\Components\TextEntry::make('mengenal_dari'),
                        Infolists\Components\TextEntry::make('fasilitas_menarik')
                            ->label('Fasilitas yang Menarik')
                            ->formatStateUsing(fn (?array $state): string => $state ? implode(', ', $state) : '-'),
                    ]),
                
                Infolists\Components\Section::make('Referensi Anggota')
                    ->schema([
                        Infolists\Components\TextEntry::make('nama_referensi_1')->label('Nama Referensi 1'),
                        Infolists\Components\TextEntry::make('no_anggota_referensi_1')->label('No. Anggota Ref. 1'),
                        Infolists\Components\TextEntry::make('nama_referensi_2')->label('Nama Referensi 2'),
                        Infolists\Components\TextEntry::make('no_anggota_referensi_2')->label('No. Anggota Ref. 2'),
                    ])->columns(2),
                
                // ===================================
                // BAGIAN YANG DIPERBAIKI ADA DI SINI
                // ===================================
                Infolists\Components\Section::make('Dokumen Terupload')
                    ->schema([
                        Infolists\Components\ImageEntry::make('path_pas_foto')->label('Pas Foto')->disk('public')->height(150)->url(fn(Registration $record) => $record->path_pas_foto ? Storage::url($record->path_pas_foto) : null, true)->columnSpan(2),
                        Infolists\Components\ImageEntry::make('path_ktp')->label('Scan KTP')->disk('public')->height(150)->url(fn(Registration $record) => $record->path_ktp ? Storage::url($record->path_ktp) : null, true)->columnSpan(2),
                        Infolists\Components\ImageEntry::make('path_sk_pegawai')->label('Scan SK')->disk('public')->height(150)->url(fn(Registration $record) => $record->path_sk_pegawai ? Storage::url($record->path_sk_pegawai) : null, true)->columnSpan(2),
                        Infolists\Components\ImageEntry::make('path_kta_referensi_1')->label('KTA Referensi 1')->disk('public')->height(150)->url(fn(Registration $record) => $record->path_kta_referensi_1 ? Storage::url($record->path_kta_referensi_1) : null, true)->columnSpan(2),
                        Infolists\Components\ImageEntry::make('path_kta_referensi_2')->label('KTA Referensi 2')->disk('public')->height(150)->url(fn(Registration $record) => $record->path_kta_referensi_2 ? Storage::url($record->path_kta_referensi_2) : null, true)->columnSpan(2),
                        Infolists\Components\ImageEntry::make('tanda_tangan')->label('Tanda Tangan')->height(80)->extraImgAttributes(['style' => 'object-fit: contain;'])->columnSpan(2),
                    ])->columns(6), // Mengubah grid utama menjadi 6 kolom
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRegistrations::route('/'),
            'edit' => Pages\EditRegistration::route('/{record}/edit'),
        ];
    }
}