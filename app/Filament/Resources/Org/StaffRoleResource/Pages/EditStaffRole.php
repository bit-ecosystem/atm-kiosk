<?php

namespace App\Filament\Resources\Org\StaffRoleResource\Pages;

use App\Filament\Resources\Org\StaffRoleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStaffRole extends EditRecord
{
    protected static string $resource = StaffRoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
