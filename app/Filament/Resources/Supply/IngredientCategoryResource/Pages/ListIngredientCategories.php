<?php

namespace App\Filament\Resources\Supply\IngredientCategoryResource\Pages;

use App\Filament\Resources\Supply\IngredientCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIngredientCategories extends ListRecords
{
    protected static string $resource = IngredientCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
