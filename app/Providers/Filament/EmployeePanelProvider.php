<?php

namespace App\Providers\Filament;

use App\Filament\Pages\AssignedOrders;
use App\Filament\Pages\CompletedOrders;
use App\Filament\Pages\DeliveryQueue;
use App\Filament\Pages\DeliveryReports;
use App\Filament\Resources\Orders\OrderResource;
use App\Filament\Widgets\EmployeeOrdersChart;
use App\Filament\Widgets\EmployeeOverview;
use App\Filament\Widgets\RecentOrdersTable;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class EmployeePanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('employee')
            ->path('employee')
              ->login()
            ->brandLogo(asset('pic/luxe-logo-light.png'))
            ->brandLogo(asset('pic/luxe-logo-dark.png'))
            ->brandLogoHeight('2rem')
            ->colors([
                'primary' => Color::Amber,
            ])
           
            // Explicit, not discovered — only Orders shows up here, nothing else.
            ->resources([
                OrderResource::class,
            ])
            ->pages([
                Dashboard::class,
                AssignedOrders::class,
                DeliveryQueue::class,
                CompletedOrders::class,
                DeliveryReports::class,
            ])
            ->widgets([
                AccountWidget::class,
                EmployeeOverview::class,
                RecentOrdersTable::class,
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
    }
}
