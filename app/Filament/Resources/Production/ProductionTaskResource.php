<?php

namespace App\Filament\Resources\Production;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use App\Filament\Resources\Production\ProductionTaskResource\Pages\ListProductionTasks;
use App\Filament\Resources\Production\ProductionTaskResource\Pages\CreateProductionTask;
use App\Filament\Resources\Production\ProductionTaskResource\Pages\ViewProductionTask;
use App\Filament\Resources\Production\ProductionTaskResource\Pages\EditProductionTask;
use App\Filament\Resources\Production\ProductionTaskResource\Pages;
use App\Filament\Resources\Production\ProductionTaskResource\RelationManagers;
use App\Models\Production\ProductionTask;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductionTaskResource extends Resource
{
    protected static ?string $model = ProductionTask::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Production';

    protected static ?string $navigationLabel = 'Tâches';


    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-c-check';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('production_id')
                    ->required()
                    ->numeric(),
                TextInput::make('production_task_type_id')
                    ->required()
                    ->numeric(),
                TextInput::make('slug')
                    ->maxLength(255),
                DatePicker::make('date')
                    ->required(),
                Textarea::make('notes')
                    ->maxLength(16777215)
                    ->columnSpanFull(),
                Toggle::make('is_finished')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('production_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('production_task_type_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('slug')
                    ->searchable(),
                TextColumn::make('date')
                    ->date()
                    ->sortable(),
                IconColumn::make('is_finished')
                    ->boolean(),
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
            'index' => ListProductionTasks::route('/'),
            'create' => CreateProductionTask::route('/create'),
            'view' => ViewProductionTask::route('/{record}'),
            'edit' => EditProductionTask::route('/{record}/edit'),
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
