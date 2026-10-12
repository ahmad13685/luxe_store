<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EmployeeOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Needs Packing', Order::whereIn('status', ['Pending', 'Payment Verified', 'Processing'])->count())
                ->description('Orders not yet packed')
                ->descriptionIcon('heroicon-m-archive-box')
                ->color('warning'),

            Stat::make('Ready to Dispatch', Order::where('status', 'Packed')->count())
                ->descriptionIcon('heroicon-m-truck')
                ->color('info'),

            Stat::make('Dispatched Today', Order::whereIn('status', ['Dispatched', 'Out For Delivery', 'Delivered'])
                ->whereDate('dispatched_at', today())
                ->count())
                ->descriptionIcon('heroicon-m-paper-airplane')
                ->color('success'),

            Stat::make('Delivered This Week', Order::where('status', 'Delivered')
                ->whereBetween('delivered_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->count())
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
        ];
    }
}
