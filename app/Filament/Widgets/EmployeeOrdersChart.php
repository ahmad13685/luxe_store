<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;

class EmployeeOrdersChart extends ChartWidget
{
    protected ?string $heading = 'Order Activity — Last 14 Days';

    protected function getData(): array
    {
        $days = collect(range(13, 0))->map(fn (int $i) => now()->subDays($i)->format('Y-m-d'));

        $newOrders = Order::selectRaw('DATE(created_at) as day, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(13)->startOfDay())
            ->groupBy('day')
            ->pluck('count', 'day');

        $delivered = Order::selectRaw('DATE(delivered_at) as day, COUNT(*) as count')
            ->where('delivered_at', '>=', now()->subDays(13)->startOfDay())
            ->groupBy('day')
            ->pluck('count', 'day');

        return [
            'datasets' => [
                [
                    'label' => 'New Orders',
                    'data' => $days->map(fn ($d) => (int) ($newOrders[$d] ?? 0))->toArray(),
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                ],
                [
                    'label' => 'Delivered',
                    'data' => $days->map(fn ($d) => (int) ($delivered[$d] ?? 0))->toArray(),
                    'borderColor' => '#22c55e',
                    'backgroundColor' => 'rgba(34, 197, 94, 0.1)',
                ],
            ],
            'labels' => $days->map(fn ($d) => \Carbon\Carbon::parse($d)->format('M j'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
