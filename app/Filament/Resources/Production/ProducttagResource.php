<?php

namespace App\Filament\Resources\Production;

use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\Production\ProducttagResource\Pages\ListProducttags;
use App\Filament\Resources\Production\ProducttagResource\Pages\CreateProducttag;
use App\Filament\Resources\Production\ProducttagResource\Pages\EditProducttag;
use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\Production\Producttag;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ColorPicker;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Production\ProducttagResource\Pages;
use App\Filament\Resources\Production\ProducttagResource\RelationManagers;

class ProducttagResource extends Resource
{
    protected static ?string $model = Producttag::class;
    protected static string | \UnitEnum | null $navigationGroup = 'Produits';

    protected static ?string $navigationLabel = 'Tags';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-tag';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
            TextInput::make('name')->required()->maxlength(255),
            ColorPicker::make('color'),
            
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            TextColumn::make('name')
            ->searchable(),
            ColorColumn::make('color'),
            TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => ListProducttags::route('/'),
            'create' => CreateProducttag::route('/create'),
            'edit' => EditProducttag::route('/{record}/edit'),
        ];
    }
}
