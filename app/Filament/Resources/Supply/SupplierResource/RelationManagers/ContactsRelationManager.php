<?php

namespace App\Filament\Resources\Supply\SupplierResource\RelationManagers;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkDownEditor;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\CreateAction;
use Filament\Actions\ActionGroup;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms;
use Filament\Tables;
use App\Enums\Departments;
use Filament\Tables\Table;
use Filament\Forms\FormsComponent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;
use App\Filament\Resources\Supply\SupplierContactResource\Pages\CreateSupplierContact;

class ContactsRelationManager extends RelationManager
{
    protected static string $relationship = 'contacts';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('supplier_id')
                ->relationship('supplier', 'name')
            ->visible(fn ($livewire) => $livewire instanceof CreateSupplierContact)
                    ->required()
                    ->label('Fournisseur'),
                TextInput::make('first_name')
                    ->required()
                    ->maxLength(30)
                    ->label('Prénom'),
                TextInput::make('last_name')
                    ->required()
                    ->maxLength(30)
                    ->label('Nom'),
                TextInput::make('phone')
                    ->tel()
                    ->maxLength(15)
                    ->label('Téléphone'),
                TextInput::make('mobile')
                    ->tel()
                    ->maxLength(15)
                    ->label('Mobile'),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(100),
                Select::make('department')
                    ->options(Departments::class),
                MarkDownEditor::make('description')
                    ->columnSpanFull()
                
            ]);
            
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('first_name')
            ->columns([
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
            ])
            ->filters([
                // 
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                ActionGroup::make ([
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
}
