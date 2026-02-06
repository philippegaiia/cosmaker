<?php

namespace App\Filament\Resources\Production\FormulaResource\Pages;

use Filament\Actions\EditAction;
use App\Filament\Resources\Production\FormulaResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewFormula extends ViewRecord
{
    protected static string $resource = FormulaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
