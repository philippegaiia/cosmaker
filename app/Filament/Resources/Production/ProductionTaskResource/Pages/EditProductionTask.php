<?php

namespace App\Filament\Resources\Production\ProductionTaskResource\Pages;

use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use App\Filament\Resources\Production\ProductionTaskResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductionTask extends EditRecord
{
    protected static string $resource = ProductionTaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
