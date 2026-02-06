<?php

namespace App\Filament\Resources\Production\ProductionTaskResource\Pages;

use Filament\Actions\EditAction;
use App\Filament\Resources\Production\ProductionTaskResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewProductionTask extends ViewRecord
{
    protected static string $resource = ProductionTaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
