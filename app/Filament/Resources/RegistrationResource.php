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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_lengkap')->disabled(),
                Forms\Components\TextInput::make('email')->email()->disabled(),
                Forms\Components\Select::make('status')
                    ->options([
                        'Menunggu Verifikasi' => 'Menunggu Verifikasi',
                        'Disetujui' => 'Disetujui',
                        'Ditolak' => 'Ditolak',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_lengkap')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->label('Tanggal Daftar'),
                Tables\Columns\TextColumn::make('status')->badge()->color(fn (string $state): string => match ($state) {
                    'Menunggu Verifikasi' => 'warning', 'Disetujui' => 'success', 'Ditolak' => 'danger',
                }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('downloadForm')
                    ->label('Download PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn (Registration $record): string => route('registration.download', ['id' => $record->id]))
                    ->openUrlInNewTab(),
            ]);
    }
    
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Data Pendaftar')
                    ->schema([
                        Infolists\Components\TextEntry::make('nama_lengkap'),
                        Infolists\Components\TextEntry::make('email'),
                        Infolists\Components\TextEntry::make('no_hp'),
                        Infolists\Components\TextEntry::make('pekerjaan'),
                        Infolists\Components\TextEntry::make('status')->badge()->color(fn (string $state): string => match ($state) {
                            'Menunggu Verifikasi' => 'warning', 'Disetujui' => 'success', 'Ditolak' => 'danger',
                        }),
                    ])->columns(3),
                
                Infolists\Components\Section::make('Dokumen Terupload')
                    ->schema([
                        Infolists\Components\ImageEntry::make('path_pas_foto')->label('Pas Foto')->disk('public'),
                        Infolists\Components\ImageEntry::make('path_ktp')->label('Scan KTP')->disk('public'),
                        Infolists\Components\ImageEntry::make('path_sk_pegawai')->label('Scan SK')->disk('public'),
                        Infolists\Components\ImageEntry::make('tanda_tangan')->label('Tanda Tangan')->height(100),
                    ])->columns(4),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRegistrations::route('/'),
            'edit' => Pages\EditRegistration::route('/{record}/edit'),
            // 'view' => Pages\ViewRegistration::route('/{record}'), // BARIS INI SUMBER ERRORNYA
        ];
    }
}