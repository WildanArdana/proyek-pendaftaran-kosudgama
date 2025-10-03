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
use Illuminate\Database\Eloquent\Builder;

class RegistrationResource extends Resource
{
    protected static ?string $model = Registration::class;
    protected static ?string $navigationIcon = 'heroicon-o-identification';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('status')
                    ->options([
                        'Menunggu Verifikasi' => 'Menunggu Verifikasi',
                        'Perlu Revisi' => 'Perlu Revisi', // Status baru
                        'Disetujui' => 'Disetujui',
                        'Ditolak' => 'Ditolak',
                    ])
                    ->required()
                    ->live(), // Membuat form menjadi reaktif

                Forms\Components\Textarea::make('rejection_reason')
                    ->label('Alasan Penolakan / Catatan Revisi')
                    ->required()
                    // Hanya tampil jika status 'Perlu Revisi' atau 'Ditolak'
                    ->visible(fn (Forms\Get $get): bool => in_array($get('status'), ['Perlu Revisi', 'Ditolak'])),
            ]);
    }

    // ... (Fungsi table() tetap sama seperti sebelumnya) ...
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_lengkap')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('user.name')->label('Nama Akun')->searchable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->label('Tanggal Daftar'),
                Tables\Columns\TextColumn::make('status')->badge()->color(fn (string $state): string => match ($state) {
                    'Menunggu Verifikasi' => 'warning', 
                    'Perlu Revisi' => 'danger',
                    'Disetujui' => 'success', 
                    'Ditolak' => 'danger',
                }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('Lihat Detail'),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('downloadForm')->label('Download PDF')->icon('heroicon-o-arrow-down-tray')->url(fn (Registration $record): string => route('registration.download', ['id' => $record->id]))->openUrlInNewTab(),
            ]);
    }


    // Infolist juga diperbarui untuk menampilkan alasan
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                // ... (semua infolist entry dari sebelumnya tetap sama) ...
                Infolists\Components\Section::make('Status Pendaftaran')
                    ->schema([
                        Infolists\Components\TextEntry::make('status')->badge()->color(fn (string $state): string => match ($state) {
                            'Menunggu Verifikasi' => 'warning', 'Perlu Revisi' => 'danger', 'Disetujui' => 'success', 'Ditolak' => 'danger',
                        }),
                        Infolists\Components\TextEntry::make('rejection_reason')
                            ->label('Catatan dari Admin')
                            ->visible(fn (Registration $record): bool => !empty($record->rejection_reason)),
                    ])->columns(2),
                
                // ... (semua seksi infolist lainnya tetap sama) ...
            ]);
    }
    
    // ... (Fungsi getPages() tetap sama seperti sebelumnya) ...
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRegistrations::route('/'),
            'edit' => Pages\EditRegistration::route('/{record}/edit'),
        ];
    }
}