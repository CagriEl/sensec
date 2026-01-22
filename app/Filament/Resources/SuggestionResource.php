<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SuggestionResource\Pages;
use App\Models\Suggestion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SuggestionResource extends Resource
{
    // Bağlı olduğu Model
    protected static ?string $model = Suggestion::class;

    // Sol menüdeki ikon (İsteğe göre değiştirebilirsiniz)
    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down';

    // Sol menüde görünecek isim
    protected static ?string $navigationLabel = 'Gelen Başvurular';
    
    // Tekil ve Çoğul İsimlendirmeler
    protected static ?string $modelLabel = 'Başvuru';
    protected static ?string $pluralModelLabel = 'Başvurular';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Düzenleme ekranındaki form yapısı
                Forms\Components\TextInput::make('name')
                    ->label('Önerilen İsim')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('ip_address')
                    ->label('IP Adresi')
                    ->disabled() // Admin IP'yi elle değiştiremesin diye kapalı
                    ->maxLength(45),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // --- TABLO SÜTUNLARI (BURASI DÜZELTİLDİ) ---
                
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->label('ID'),

                Tables\Columns\TextColumn::make('name')
                    ->label('Önerilen İsim')
                    ->searchable() // Arama kutusu ile aranabilir
                    ->sortable()
                    ->weight('bold'), // Yazıyı kalın yapar

                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP Adresi')
                    ->fontFamily('mono') // Kod fontu gibi görünür
                    ->copyable() // Üzerine tıklayınca kopyalar
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Başvuru Tarihi')
                    ->dateTime('d.m.Y H:i') // Gün.Ay.Yıl Saat:Dakika formatı
                    ->sortable(),
            ])
            ->filters([
                // Filtre eklemek isterseniz buraya
            ])
            ->actions([
                // Satır sonundaki butonlar
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // --- TOPLU İŞLEMLER ---
                // Hatanın kaynağı burasıydı, şimdi doğru yapıda:
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // İlişkiler varsa buraya
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSuggestions::route('/'),
            'create' => Pages\CreateSuggestion::route('/create'),
            'edit' => Pages\EditSuggestion::route('/{record}/edit'),
        ];
    }
}