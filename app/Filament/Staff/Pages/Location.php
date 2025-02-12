<?php

namespace App\Filament\Staff\Pages;

use Filament\Pages\Page;

class Location extends Page
{
    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Organization';

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    protected static string $view = 'filament.staff.pages.location';
}
