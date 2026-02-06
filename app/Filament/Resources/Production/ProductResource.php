<?php

namespace App\Filament\Resources\Production;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use App\Filament\Resources\Production\ProductResource\Pages\ListProducts;
use App\Filament\Resources\Production\ProductResource\Pages\CreateProduct;
use App\Filament\Resources\Production\ProductResource\Pages\EditProduct;
use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\Production\Formula;
use App\Models\Production\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Production\ProductResource\Pages;
use App\Filament\Resources\Production\ProductResource\RelationManagers;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Produits';

    protected static ?string $navigationLabel = 'Produits';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('product_category_id')
                    ->relationship('product_category', 'name')
                    ->native(false)
                    ->required(),
                    
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('code')
                    ->maxLength(255),
                Select::make('producttags')
                    ->relationship('producttags', 'name')
                    ->preload()
                    ->multiple(),
             /*   Forms\Components\Select::make('formula_id')
                   // ->relationship('formulas', 'name')
                    ->options(Formula::all()->pluck('name', 'id'))
                    ->preload()
                    ->required(),*/
                TextInput::make('wp_code')
                    ->maxLength(255),
                
                DatePicker::make('launch_date')
                    ->native(false)    
                    ->required(),
                TextInput::make('net_weight')
                    ->required()
                    ->numeric(),
                TextInput::make('ean_code')
                    ->maxLength(255),
                MarkdownEditor::make('description')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->onColor('success')
                    ->offColor('warning')
                    ->required()
                    ,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('product_category.name')
                    ->sortable(),
                TextColumn::make('producttags.name')
                    ->badge(),
                   // ->color('producttags.color'),
                TextColumn::make('formulas.name')
                ->badge(),
                //->color('producttags.color'),"Color: {$record->color}"
                TextColumn::make('code')
                    ->searchable(),
                TextColumn::make('wp_code')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),              
                TextColumn::make('launch_date')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('net_weight')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('ean_code')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                ToggleColumn::make('is_active')
                    ->sortable(),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
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
            'index' => ListProducts::route('/'),
            'create' => CreateProduct::route('/create'),
            'edit' => EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
