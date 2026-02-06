<?php

namespace App\Filament\Resources\Production\ProducttagResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\Production\ProducttagResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProducttags extends ListRecords
{
    protected static string $resource = ProducttagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
