<?php

namespace App\Filament\Editor\Resources\EipResource\Pages;

use App\Filament\Editor\Resources\EipResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEips extends ListRecords
{
    protected static string $resource = EipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
