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

class RegistrationResource extends Resource
{
    protected static ?string $model = Registration::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    protected static ?string $navigationLabel = 'Pendaftar Anggota';

    protected static ?string $modelLabel = 'Pendaftar Baru';

    // Kita tidak akan membuat form baru dari admin, hanya melihat/edit status
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_lengkap')
                    ->required()
                    ->disabledOn('edit'),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->disabledOn('edit'),
                Forms\Components\Select::make('status')
                    ->options([
                        'Menunggu Verifikasi' => 'Menunggu Verifikasi',
                        'Disetujui' => 'Disetujui',
                        'Ditolak' => 'Ditolak',
                    ])
                    ->required(),
            ]);
    }

    // Mengatur tabel yang akan ditampilkan di admin panel
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_lengkap')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('no_hp')->label('No. HP'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->label('Tanggal Daftar'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Menunggu Verifikasi' => 'warning',
                        'Disetujui' => 'success',
                        'Ditolak' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('downloadPdf')
                    ->label('Download PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn (Registration $record): string => route('registration.download-pdf', $record))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    
    // Halaman untuk melihat detail data pendaftar (View)
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Data Pribadi')
                    ->schema([
                        Infolists\Components\TextEntry::make('nama_lengkap'),
                        Infolists\Components\TextEntry::make('jenis_kelamin'),
                        Infolists\Components\TextEntry::make('tempat_lahir'),
                        Infolists\Components\TextEntry::make('tanggal_lahir')->date('d F Y'),
                    ])->columns(2),
                Infolists\Components\Section::make('Kontak & Alamat')
                    ->schema([
                        Infolists\Components\TextEntry::make('email'),
                        Infolists\Components\TextEntry::make('no_hp')->label('No. HP'),
                        Infolists\Components\TextEntry::make('no_ktp')->label('No. KTP'),
                        Infolists\Components\TextEntry::make('alamat_ktp')->columnSpanFull(),
                        Infolists\Components\TextEntry::make('alamat_rumah')->columnSpanFull()->label('Alamat Rumah Saat Ini'),
                    ])->columns(3),
                Infolists\Components\Section::make('Pekerjaan')
                    ->schema([
                        Infolists\Components\TextEntry::make('pekerjaan'),
                        Infolists\Components\TextEntry::make('nama_instansi'),
                        Infolists\Components\TextEntry::make('alamat_instansi'),
                    ])->columns(2),
                Infolists\Components\Section::make('Referensi')
                    ->schema([
                        Infolists\Components\TextEntry::make('nama_referensi_1')->label('Nama Referensi 1'),
                        Infolists\Components\TextEntry::make('no_anggota_referensi_1')->label('No. Anggota Referensi 1'),
                        Infolists\Components\TextEntry::make('nama_referensi_2')->label('Nama Referensi 2'),
                        Infolists\Components\TextEntry::make('no_anggota_referensi_2')->label('No. Anggota Referensi 2'),
                    ])->columns(2),
                Infolists\Components\Section::make('Dokumen & Tanda Tangan')
                    ->schema([
                        Infolists\Components\ImageEntry::make('path_pas_foto')->label('Pas Foto')->height(150),
                        Infolists\Components\ImageEntry::make('path_ktp')->label('Scan KTP')->height(150),
                        Infolists\Components\ImageEntry::make('path_sk_pegawai')->label('Scan SK')->height(150),
                        Infolists\Components\ImageEntry::make('tanda_tangan')->label('Tanda Tangan Digital')->height(150),
                    ])->columns(4),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRegistrations::route('/'),
            'create' => Pages\CreateRegistration::route('/create'),
            // 'view' => Pages\ViewRegistration::route('/{record}'), // <-- Baris ini kita hapus/komentari
            'edit' => Pages\EditRegistration::route('/{record}/edit'),
        ];
    }

    // Menonaktifkan tombol "Create" dari halaman utama resource ini
    public static function canCreate(): bool
    {
        return false;
    }
}
