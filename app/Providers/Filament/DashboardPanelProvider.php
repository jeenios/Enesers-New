<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\InactiveUsersChart;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use App\Filament\Widgets\UnverifiedUsersChart;
use App\Filament\Widgets\UsersChart;
use Filament\Facades\Filament;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
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
use Filament\Navigation\MenuItem;
use Filament\Navigation\NavigationItem;
use Filament\Pages\Auth\EditProfile;
use Filament\Widgets\AccountWidget;
use Leandrocfe\FilamentApexCharts\FilamentApexChartsPlugin;
use AlperenErsoy\FilamentExport\FilamentExportPlugin;

class DashboardPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('dashboard')
            ->path('dashboard')
            ->registration()
            ->emailVerification()
            ->passwordReset()
            ->profile()
            ->login()
            ->authGuard('web')
            // ->font('popins')
            ->databaseNotifications()
            ->sidebarCollapsibleOnDesktop()
            ->userMenuItems([
                'profile' => MenuItem::make()
                    ->label(fn() => Filament::auth()->user()?->employee_name)
                    ->url(fn() => EditProfile::getUrl()),
            ])

            ->colors([
                'primary' => Color::Teal,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->plugins([
                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make(),
                FilamentApexChartsPlugin::make(),
            ])
            ->widgets([
                AccountWidget::class,
                // UsersChart::class,
                // InactiveUsersChart::class,
                // UnverifiedUsersChart::class,
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
            ])
            ->brandName('Simpro Management Sistem')
            ->brandLogo(asset('images/Enesers.png'))
            ->brandLogoHeight('170px')
            ->favicon(asset('images/Enesers.png'));
    }
}
