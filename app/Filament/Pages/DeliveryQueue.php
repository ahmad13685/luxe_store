<?php

namespace App\Filament\Pages;

use App\Models\Order;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class DeliveryQueue extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedTruck;

    protected static string|\UnitEnum|null $navigationGroup = 'Order Operations';

    protected static ?string $navigationLabel = 'Delivery Queue';

    protected static ?string $title = 'Delivery Queue';

    protected string $view = 'filament.pages.simple-orders-table';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::query()->whereIn('status', [
                    Order::STATUS_PACKED,
                    Order::STATUS_DISPATCHED,
                    Order::STATUS_OUT_FOR_DELIVERY,
                ])
            )
            ->columns([
                TextColumn::make('order_number')
                    ->label('Order')
                    ->searchable(),

                TextColumn::make('customer.name')
                    ->label('Customer')
                    ->searchable(),

                TextColumn::make('status')
                    ->badge(),

                TextColumn::make('dispatched_at')
                    ->dateTime()
                    ->label('Dispatched'),

                TextColumn::make('total_amount')
                    ->money('USD'),
            ])
            ->recordActions([
                Action::make('dispatch')
                    ->label('Dispatch')
                    ->icon('heroicon-o-truck')
                    ->color('success')
                    ->visible(
                        fn (Order $record): bool =>
                            is_null($record->dispatched_at)
                    )
                    ->requiresConfirmation()
                    ->action(function (Order $record): void {
                        if (! $record->canBeDispatched()) {
                            Notification::make()
                                ->title('Cannot dispatch — payment not cleared yet')
                                ->danger()
                                ->send();

                            return;
                        }

                        $record->update([
                            'status' => Order::STATUS_DISPATCHED,
                            'dispatched_by' => auth()->id(),
                            'dispatched_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Order dispatched')
                            ->success()
                            ->send();
                    }),

                Action::make('markDelivered')
                    ->label('Mark Delivered')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(
                        fn (Order $record): bool =>
                            ! is_null($record->dispatched_at)
                            && is_null($record->delivered_at)
                    )
                    ->requiresConfirmation()
                    ->action(function (Order $record): void {
                        $record->update([
                            'status' => Order::STATUS_DELIVERED,
                            'delivered_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Order marked as delivered')
                            ->success()
                            ->send();
                    }),
            ]);
    }
}

