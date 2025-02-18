<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class AccountWidget extends Widget
{
    protected static string $view = 'filament-panels::widgets.account-widget';

    protected function getViewData(): array
    {
        return [
            'user' => Auth::user(),
        ];
    }
}
