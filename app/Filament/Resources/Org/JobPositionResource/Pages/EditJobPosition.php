<?php

namespace App\Filament\Resources\Org\JobPositionResource\Pages;

use App\Filament\Resources\Org\JobPositionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJobPosition extends EditRecord
{
    protected static string $resource = JobPositionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
