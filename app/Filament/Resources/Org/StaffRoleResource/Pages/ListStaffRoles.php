<?php

namespace App\Filament\Resources\Org\StaffRoleResource\Pages;

use App\Filament\Resources\Org\StaffRoleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStaffRoles extends ListRecords
{
    protected static string $resource = StaffRoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
