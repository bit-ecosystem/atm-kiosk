<?php

namespace App\Filament\Resources\ServiceMenuResource\Pages;

use App\Filament\Resources\ServiceMenuResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListServiceMenus extends ListRecords
{
    protected static string $resource = ServiceMenuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
