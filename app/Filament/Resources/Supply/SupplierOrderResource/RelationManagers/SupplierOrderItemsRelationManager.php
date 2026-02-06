<?php

namespace App\Filament\Resources\Supply\SupplierOrderResource\RelationManagers;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use App\Models\Supply\SupplierListing;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class SupplierOrderItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'supplier_order_items';

    public int $supplierId;
    

   /* public function getSupplierId(RelationManager $livewire): array {
                         return  $livewire->getOwnerRecord()->supplier()->pluck('supplier_id')->toArray();
                         dd($livewire->getOwnerRecord()->supplier()->pluck('supplier_id')->toArray());
                       // 
                        //->toArray();
                        } */

    public function form(Schema $schema): Schema
    {
        return $schema
        
                ->components([
                    
                   /* Select::make('supplier_listing_id')
                        ->relationship(
                            name: 'supplier_listing', 
                            titleAttribute: 'name',
                        )*/
                        Select::make('supplier_listing_id')
                        ->options(function (RelationManager $livewire): array {
                            return $livewire->getOwnerRecord()->supplier_listings()
                        ->pluck('name', 'id')
                        ->toArray();
                            })
                        ->live()
                        ->afterStateUpdated(function ($state, Get $get, Set $set, ) {
                                $supplier_listing = SupplierListing::find($state);
                                $set('unit_weight', $supplier_listing->unit_weight);
                            }) 
                        ->preload() 
                        ->required()
                        ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                        ->native(false)
                        ->columnSpan(3)
                        ->searchable(),

                    TextInput::make('quantity')
                        ->numeric()
                        ->live()
                        ->dehydrated()
                        ->default(1)
                        ->columnSpan(1),

                    TextInput::make('unit_weight')
                        ->label('Poids')
                        ->disabled()
                        ->dehydrated()
                        ->default(1)
                        ->columnSpan(1),

                    TextInput::make('unit_price')
                        ->label('Prix')
                        // ->dehydrated()
                        ->numeric()
                        ->columns(1),

                    TextInput::make('batch_number')
                        ->label('No. Lot')
                        ->columnSpan(1),

                    DatePicker::make('expiry_date')
                        ->label('DLUO')
                        //->format('d/m/Y')
                        ->native(false)
                        ->closeOnDateSelection()
                        ->columnSpan(1),

                    Placeholder::make('total_quantity')
                        ->label('Quantité Totale')
                        ->content(function ($get) {
                            return $get('quantity') * $get('unit_weight');
                        })->columnSpan(1),

                    Checkbox::make('is_in_supplies')
                        ->disabled()
                        ->inline(false)
                        ->columnSpan(1),

                    ]);
            
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('supplier_listing.name'),
                TextColumn::make('unit_weight'),
            ])
            ->filters([
                TrashedFilter::make()
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
                ForceDeleteAction::make(),
                RestoreAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]));
    }
}
