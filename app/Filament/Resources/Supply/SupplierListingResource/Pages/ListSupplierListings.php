<?php

namespace App\Filament\Resources\Supply\SupplierListingResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\Supply\SupplierListingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSupplierListings extends ListRecords
{
    protected static string $resource = SupplierListingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
