<?php

namespace App\Filament\Resources\Production;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Fieldset;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use App\Filament\Resources\Production\ProductionResource\Pages\ListProductions;
use App\Filament\Resources\Production\ProductionResource\Pages\CreateProduction;
use App\Filament\Resources\Production\ProductionResource\Pages\ViewProduction;
use App\Filament\Resources\Production\ProductionResource\Pages\EditProduction;
use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use App\Enums\ProductionStatus;
use Filament\Resources\Resource;
use App\Models\Production\Formula;
use App\Models\Production\Product;
use App\Models\Production\Production;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ToggleButtons;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Production\ProductionResource\Pages;
use App\Filament\Resources\Production\ProductionResource\RelationManagers;

class ProductionResource extends Resource
{
    protected static ?string $model = Production::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Production';

    protected static ?string $navigationLabel = 'Production';


    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('product_id')
                    ->relationship('product', 'name')
                    ->native(false)
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function (Set $set, Get $get, ?string $state) {
                        $prodId = $get('product_id');
                    //    dd((int)$prodId);
                    //    $product = Product::find(1)->get(); 
                        $formula = Product::find((int)$prodId)->formulas()
                        //->where('is_active', true)
                        ->first();

                        if ($formula) {
                            $formulaId = $formula->id;
                            $set('formula_id', $formulaId);
                        }
                      //  $formula = Product::find(1)->formula;
                       // dd($formula);
                    })
                    ->required(),
                Select::make('formula_id')
                    ->relationship('formula', 'name')
                    ->disabled()
                    ->dehydrated()
                    ->required(),
                Select::make('parent_id')
                    ->label('Masterbatch')
                    ->relationship('parent', 'id'),
                ToggleButtons::make('is_masterbatch')
                    ->label('Masterbatch')
                    ->inline(false)
                    ->default(false)
                    ->boolean()
                    ->grouped()
                    ->required(),
                TextInput::make('slug')
                    ->maxLength(255),
                TextInput::make('batch_number')
                    ->required()
                    ->maxLength(255),
                ToggleButtons::make('status')
                    ->options(ProductionStatus::class)
                    ->inline()
                    ->required()
                    ->default(ProductionStatus::Planned),
                Fieldset::make('Dates')
                    ->schema([
                        DatePicker::make('production_date')
                            ->required()
                            ->default(now())
                            ->native(false)
                            ->weekStartsOnMonday(),
                        DatePicker::make('ready_date')
                            ->afterOrEqual('production_date')
                            ->native(false)
                            ->weekStartsOnMonday()
                ])->columnSpanFull(),
                TextInput::make('quantity_ingredients')
                    ->numeric(),
                TextInput::make('units_produced')
                    ->numeric(),
                Toggle::make('organic')
                    ->required(),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('formula_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('parent.id')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_masterbatch')
                    ->boolean(),
                TextColumn::make('slug')
                    ->searchable(),
                TextColumn::make('batch_number')
                    ->searchable(),
                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('production_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('ready_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('quantity_ingredients')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('units_produced')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('organic')
                    ->boolean(),
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
                ViewAction::make(),
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
            'index' => ListProductions::route('/'),
            'create' => CreateProduction::route('/create'),
            'view' => ViewProduction::route('/{record}'),
            'edit' => EditProduction::route('/{record}/edit'),
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
