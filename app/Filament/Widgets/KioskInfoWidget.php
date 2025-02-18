<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class KioskInfoWidget extends Widget
{
    protected static string $view = 'filament-panels::widgets.kiosk-info-widget';

    protected function getViewData(): array
    {
        return [
            'user' => Auth::user(),
        ];
    }
}
