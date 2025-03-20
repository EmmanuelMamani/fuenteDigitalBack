<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommercialResource\Pages;
use App\Filament\Resources\CommercialResource\RelationManagers;
use App\Models\Commercial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BooleanColumn;
use Illuminate\Support\Facades\Storage;
class CommercialResource extends Resource
{
    protected static ?string $model = Commercial::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('company')
                ->label('Empresa')
                ->required()
                ->maxLength(100),

                TextInput::make('duration')
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(100),
                Toggle::make('active')->label('activo')->accepted(),

                FileUpload::make('path')
                    ->image()
                    ->label('Imagen')
                    ->directory('commercials/images')
                    ->maxSize(2048)
                    ->required()
                    ->visibility('public')->deleteUploadedFileUsing(fn ($file) => Storage::disk('public')->delete($file)),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('company')
                    ->label('Empresa')
                    ->sortable(),

                TextColumn::make('duration')
                    ->label('Duracion')
                     ->suffix(' min.'),

                BooleanColumn::make('active')
                     ->label('Activo')
                     ->trueIcon('heroicon-o-check-circle')
                     ->falseIcon('heroicon-o-x-circle')
                     ->sortable(),

                ImageColumn::make('path')
                    ->label('Imagen'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListCommercials::route('/'),
            'create' => Pages\CreateCommercial::route('/create'),
            'edit' => Pages\EditCommercial::route('/{record}/edit'),
        ];
    }
}
