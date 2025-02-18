<?php

namespace App\Filament\Staff\Resources\EmployeeHandbookResource\Pages;

use App\Filament\Staff\Resources\EmployeeHandbookResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmployeeHandbooks extends ListRecords
{
    protected static string $resource = EmployeeHandbookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
