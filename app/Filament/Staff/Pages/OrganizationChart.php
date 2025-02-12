<?php

namespace App\Filament\Staff\Pages;

use Filament\Pages\Page;

class OrganizationChart extends Page
{
    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'Organization';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static string $view = 'filament.staff.pages.organization-chart';
}
