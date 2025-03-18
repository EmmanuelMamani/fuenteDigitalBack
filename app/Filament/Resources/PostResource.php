<?php

namespace App\Filament\Resources;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use Filament\Forms\Components\RichEditor;
use App\Models\Post;
use App\Models\Section;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\TextColumn;
class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Título')
                    ->required()
                    ->maxLength(100),

                Select::make('section_id')
                    ->label('Sección')
                    ->options(
                        Section::usableSections()->pluck('name', 'id')->toArray()
                    )
                    ->required(),

                TagsInput::make('labels')
                    ->label('Etiquetas')
                    ->dehydrated(false),

                RichEditor::make('description')
                    ->label('Contenido')
                    ->required()
                    ->toolbarButtons([
                        'bold', 'italic', 'underline', 'link', 'strike', 'blockquote', 'bulletList', 'orderedList', 'codeBlock', 'code', 'undo', 'redo'
                    ])->columnSpanFull(),
            ]);
    }
    public static function getEloquentQuery(): Builder
{
    return parent::getEloquentQuery()->with('labels');
}
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Titulo')
                    ->sortable(),
                TagsColumn::make('labels.name')
                    ->label('Etiquetas')
                    ->separator(', ')
                    ->limit(3)  // Muestra hasta 3 etiquetas
                    ->colors(['primary']),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
