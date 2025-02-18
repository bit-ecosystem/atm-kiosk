<?php

namespace App\Filament\Resources\ServiceMenuResource\Pages;

use App\Filament\Resources\ServiceMenuResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditServiceMenu extends EditRecord
{
    protected static string $resource = ServiceMenuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
