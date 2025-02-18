<?php

namespace App\Filament\Auth;

use Filament\Http\Responses\Auth\Contracts\LogoutResponse as ContractsLogoutResponse;
use Illuminate\Http\RedirectResponse;
class LogoutResponse implements ContractsLogoutResponse
{
    public function toResponse($request)
    {
        return redirect()->route('landing');
    }
}
