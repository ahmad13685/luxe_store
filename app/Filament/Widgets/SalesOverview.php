<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SalesOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $lowStockCount = Product::where('stock', '<=', 5)->count();

        return [
            Stat::make('Orders Today', Order::whereDate('created_at', today())->count())
                ->description('New orders placed today')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('success'),

            Stat::make('Revenue (This Month)', 'Rs. ' . number_format(
                Order::whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->where('status', '!=', 'Cancelled')
                    ->sum('total_amount'),
                2
            ))
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('Pending Orders', Order::where('status', 'Pending')->count())
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Low Stock Products', $lowStockCount)
                ->description('5 units or fewer')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($lowStockCount > 0 ? 'danger' : 'success'),
        ];
    }
}
