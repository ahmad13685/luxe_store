<?php

namespace App\Filament\Pages;

use App\Models\Order;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class CompletedOrders extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedCheckCircle;

    protected static string|\UnitEnum|null $navigationGroup = 'Order Operations';

    protected static ?string $navigationLabel = 'Completed Orders';

    protected static ?string $title = 'Completed Orders';

    protected string $view = 'filament.pages.simple-orders-table';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::query()
                    ->where('status', Order::STATUS_DELIVERED)
                    ->latest('delivered_at')
            )
            ->columns([
                TextColumn::make('order_number')
                    ->label('Order')
                    ->searchable(),

                TextColumn::make('customer.name')
                    ->label('Customer'),

                TextColumn::make('total_amount')
                    ->money('USD'),

                TextColumn::make('dispatched_at')
                    ->dateTime(),

                TextColumn::make('delivered_at')
                    ->dateTime(),
            ]);
    }
}

