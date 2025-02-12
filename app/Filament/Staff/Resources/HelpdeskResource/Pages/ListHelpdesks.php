<?php

namespace App\Filament\Staff\Resources\HelpdeskResource\Pages;

use App\Filament\Staff\Resources\HelpdeskResource;
use Filament\Resources\Pages\ListRecords;

class ListHelpdesks extends ListRecords
{
    protected static string $resource = HelpdeskResource::class;

    public function getTitle(): string
    {
        return 'Helpdesk & Support';
    }

    public function getBreadcrumbs(): array
    {
        return [];
    }
}
