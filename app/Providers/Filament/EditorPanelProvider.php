<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class EditorPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $panel = $panel
            ->id('editor')
            ->homeUrl('/')
            ->path('editor')
            ->colors([
                'primary' => Color::Fuchsia,
            ])
            ->discoverResources(in: app_path('Filament/Editor/Resources'), for: 'App\\Filament\\Editor\\Resources')
            ->discoverPages(in: app_path('Filament/Editor/Pages'), for: 'App\\Filament\\Editor\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Editor/Widgets'), for: 'App\\Filament\\Editor\\Widgets')
            ->widgets([
                \App\Filament\Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);

        // Discover additional resources, pages, and widgets in Modules
        $modulePaths = glob(app_path('Modules/*/App/Filament/Editor/Resources'), GLOB_ONLYDIR);
        foreach ($modulePaths as $path) {
            $namespace = 'App\\' . str_replace('/', '\\', str_replace(app_path() . '/', '', $path));
            $panel->discoverResources(in: $path, for: $namespace);
        }

        $modulePaths = glob(app_path('Modules/*/App/Filament/Editor/Pages'), GLOB_ONLYDIR);
        foreach ($modulePaths as $path) {
            $namespace = 'App\\' . str_replace('/', '\\', str_replace(app_path() . '/', '', $path));
            $panel->discoverPages(in: $path, for: $namespace);
        }

        $modulePaths = glob(app_path('Modules/*/App/Filament/Editor/Widgets'), GLOB_ONLYDIR);
        foreach ($modulePaths as $path) {
            $namespace = 'App\\' . str_replace('/', '\\', str_replace(app_path() . '/', '', $path));
            $panel->discoverWidgets(in: $path, for: $namespace);
        }

        return $panel;
    }
}
