<?php

namespace App\Filament\Editor\Resources\EipResource\Pages;

use App\Filament\Editor\Resources\EipResource;
use Filament\Resources\Pages\EditRecord;

class EditEip extends EditRecord
{
    protected static string $resource = EipResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
