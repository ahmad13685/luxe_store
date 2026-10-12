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

class AssignedOrders extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedInbox;

    protected static string|\UnitEnum|null $navigationGroup = 'Order Operations';

    protected static ?string $navigationLabel = 'Assigned Orders';

    protected static ?string $title = 'Assigned Orders';

    protected string $view = 'filament.pages.simple-orders-table';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::query()->whereIn('status', [
                    Order::STATUS_PENDING,
                    Order::STATUS_PAYMENT_VERIFIED,
                    Order::STATUS_PROCESSING,
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

                TextColumn::make('payment_status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'cleared' => 'success',
                        'failed' => 'danger',
                        default => 'warning',
                    }),

                TextColumn::make('total_amount')
                    ->money('USD'),

                TextColumn::make('created_at')
                    ->since()
                    ->label('Placed'),
            ])
            ->recordActions([
                Action::make('markProcessing')
                    ->label('Mark Processing')
                    ->icon('heroicon-o-arrow-path')
                    ->visible(
                        fn (Order $record): bool =>
                            $record->status !== Order::STATUS_PROCESSING
                    )
                    ->action(function (Order $record): void {
                        $record->update([
                            'status' => Order::STATUS_PROCESSING,
                        ]);

                        Notification::make()
                            ->title('Order marked as processing')
                            ->success()
                            ->send();
                    }),

                Action::make('markPacked')
                    ->label('Mark Packed')
                    ->icon('heroicon-o-archive-box')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(
                        fn (Order $record): bool =>
                            $record->status === Order::STATUS_PROCESSING
                    )
                    ->action(function (Order $record): void {
                        $record->update([
                            'status' => Order::STATUS_PACKED,
                        ]);

                        Notification::make()
                            ->title('Order marked as packed')
                            ->success()
                            ->send();
                    }),
            ]);
    }
}
