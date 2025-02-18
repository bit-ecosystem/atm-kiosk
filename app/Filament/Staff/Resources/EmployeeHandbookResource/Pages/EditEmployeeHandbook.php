<?php

namespace App\Filament\Staff\Resources\EmployeeHandbookResource\Pages;

use App\Filament\Staff\Resources\EmployeeHandbookResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmployeeHandbook extends EditRecord
{
    protected static string $resource = EmployeeHandbookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
