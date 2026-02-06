<?php

namespace App\Filament\Resources\Production\FormulaResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\Production\FormulaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFormulas extends ListRecords
{
    protected static string $resource = FormulaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()       
        ];
    }
}
