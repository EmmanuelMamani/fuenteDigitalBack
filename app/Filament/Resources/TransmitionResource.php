<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransmitionResource\Pages;
use App\Filament\Resources\TransmitionResource\RelationManagers;
use App\Models\Transmition;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BooleanColumn;
class TransmitionResource extends Resource
{
    protected static ?string $model = Transmition::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('url')
                ->label('Enlace')
                ->required()
                ->maxLength(100)
                ->prefixIcon('heroicon-o-link'),

                Select::make('type')
                    ->label('Red Social')
                    ->options([
                        'facebook' => 'Facebook',
                        'tik tok' => 'Tik Tok',
                    ])
                    ->required(),

                Toggle::make('online')->label('Transmitiendo')->accepted(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('url')
                    ->label('Enlace'),
                TextColumn::make('type')
                    ->label('Red social')
                    ->sortable(),
                BooleanColumn::make('online')
                     ->label('Online')
                     ->trueIcon('heroicon-o-check-circle')
                     ->falseIcon('heroicon-o-x-circle')
                     ->sortable()
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
            'index' => Pages\ListTransmitions::route('/'),
            'create' => Pages\CreateTransmition::route('/create'),
            'edit' => Pages\EditTransmition::route('/{record}/edit'),
        ];
    }
}
