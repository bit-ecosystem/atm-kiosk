<?php

namespace App\Filament\Resources\Org\JobRoleResource\Pages;

use App\Filament\Resources\Org\JobRoleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJobRole extends EditRecord
{
    protected static string $resource = JobRoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
