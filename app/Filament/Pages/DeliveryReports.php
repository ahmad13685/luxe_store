<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\EmployeeOrdersChart;
use App\Filament\Widgets\EmployeeOverview;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class DeliveryReports extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    protected static string|\UnitEnum|null $navigationGroup = 'Order Operations';

    protected static ?string $navigationLabel = 'Delivery Reports';

    protected static ?string $title = 'Delivery Reports';

    protected string $view = 'filament.pages.delivery-reports';

    protected function getHeaderWidgets(): array
    {
        return [
            EmployeeOverview::class,
            EmployeeOrdersChart::class,
        ];
    }
}

