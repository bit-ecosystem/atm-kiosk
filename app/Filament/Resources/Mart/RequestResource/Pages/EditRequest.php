<?php

namespace App\Filament\Resources\Mart\RequestResource\Pages;

use App\Filament\Resources\Mart\RequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRequest extends EditRecord
{
    protected static string $resource = RequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
