<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentOrdersTable extends BaseWidget
{
    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    protected function getTableHeading(): string
    {
        return 'Orders Needing Action';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::query()
                    ->whereIn('status', ['Pending', 'Payment Verified', 'Processing', 'Packed'])
                    ->latest()
            )
            ->columns([
                TextColumn::make('order_number')->label('Order #'),
                TextColumn::make('customer.name')->label('Customer'),
                TextColumn::make('status')->badge(),
                TextColumn::make('payment_status')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'cleared' => 'success',
                        'failed' => 'danger',
                        default => 'warning',
                    }),
                TextColumn::make('total_amount')->money('usd'),
                TextColumn::make('created_at')->since()->label('Placed'),
            ])
            ->recordActions([
                Action::make('dispatch')
                    ->label('Dispatch')
                    ->icon('heroicon-o-truck')
                    ->color('success')
                    ->visible(fn (Order $record) => is_null($record->dispatched_at))
                    ->requiresConfirmation()
                    ->action(function (Order $record) {
                        if (! $record->canBeDispatched()) {
                            Notification::make()
                                ->title('Cannot dispatch — payment not cleared yet')
                                ->danger()
                                ->send();

                            return;
                        }

                        $record->update([
                            'status' => 'Dispatched',
                            'dispatched_by' => auth()->id(),
                            'dispatched_at' => now(),
                        ]);

                        Notification::make()->title('Order dispatched')->success()->send();
                    }),
            ])
            ->paginated([5, 10, 25]);
    }
}
