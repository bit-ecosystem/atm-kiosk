<?php

namespace App\Filament\Resources\Org\JobRoleResource\Pages;

use App\Filament\Resources\Org\JobRoleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJobRoles extends ListRecords
{
    protected static string $resource = JobRoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
