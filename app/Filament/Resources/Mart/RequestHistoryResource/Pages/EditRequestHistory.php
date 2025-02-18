<?php

namespace App\Filament\Resources\Mart\RequestHistoryResource\Pages;

use App\Filament\Resources\Mart\RequestHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRequestHistory extends EditRecord
{
    protected static string $resource = RequestHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
