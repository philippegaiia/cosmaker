<?php

namespace App\Filament\Resources\Supply;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkDownEditor;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\ActionGroup;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\Supply\SupplierContactResource\Pages\ListSupplierContacts;
use App\Filament\Resources\Supply\SupplierContactResource\Pages\CreateSupplierContact;
use App\Filament\Resources\Supply\SupplierContactResource\Pages\EditSupplierContact;
use Filament\Forms;
use Filament\Tables;
use App\Enums\Departments;
//use Filament\Actions\ActionGroup;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\Supply\SupplierContact;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Supply\SupplierContactResource\Pages;
use App\Filament\Resources\Supply\SupplierContactResource\RelationManagers;

class SupplierContactResource extends Resource
{
    protected static ?string $model = SupplierContact::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Achats';

    protected static ?string $navigationLabel = 'Contacts Fournisseurs';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-user-group';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('supplier_id')
                    ->relationship('supplier', 'name')
                    ->required(),
                TextInput::make('first_name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('last_name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('phone')
                    ->tel()
                    ->maxLength(255),
                TextInput::make('mobile')
                    ->tel()
                    ->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Select::make('department')
                    ->options(Departments::class),
                MarkDownEditor::make('description')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('supplier.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('first_name')
                    ->searchable(),
                TextColumn::make('last_name')
                    ->searchable(),
                TextColumn::make('phone')
                    ->searchable(),
                TextColumn::make('mobile')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('department')
                    ->searchable(),
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
                ActionGroup::make([
                     EditAction::make(),
                     DeleteAction::make(),
                ])
               
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
            'index' => ListSupplierContacts::route('/'),
            'create' => CreateSupplierContact::route('/create'),
            'edit' => EditSupplierContact::route('/{record}/edit'),
        ];
    }
}
