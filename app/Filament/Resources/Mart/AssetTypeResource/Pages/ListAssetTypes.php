<?php

namespace App\Filament\Resources\Mart\AssetTypeResource\Pages;

use App\Filament\Resources\Mart\AssetTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAssetTypes extends ListRecords
{
    protected static string $resource = AssetTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
