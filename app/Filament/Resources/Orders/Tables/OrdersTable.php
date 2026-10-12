<?php

namespace App\Filament\Resources\Orders\Tables;

use App\Models\Order;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number')->searchable(),
                TextColumn::make('customer.name'),
                TextColumn::make('status')->badge(),
                TextColumn::make('payment_method'),
                TextColumn::make('payment_status')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'cleared' => 'success',
                        'failed' => 'danger',
                        default => 'warning',
                    }),
                TextColumn::make('total_amount')->money('usd')->sortable(),
                TextColumn::make('dispatched_at')->dateTime()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('delivered_at')->dateTime()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'Pending' => 'Pending', 'Payment Verified' => 'Payment Verified',
                        'Processing' => 'Processing', 'Packed' => 'Packed',
                        'Dispatched' => 'Dispatched', 'Out For Delivery' => 'Out For Delivery',
                        'Delivered' => 'Delivered', 'Cancelled' => 'Cancelled',
                    ]),
                SelectFilter::make('payment_status')
                    ->options(['pending' => 'Pending', 'cleared' => 'Cleared', 'failed' => 'Failed']),
            ])
            ->recordActions([
                // Business rule: block dispatch until payment has cleared
                // (Cash on Delivery skips this check — see Order::canBeDispatched()).
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

                Action::make('markDelivered')
                    ->label('Mark Delivered')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Order $record) => $record->dispatched_at && is_null($record->delivered_at))
                    ->requiresConfirmation()
                    ->action(fn (Order $record) => $record->update([
                        'status' => 'Delivered',
                        'delivered_at' => now(),
                    ])),

                EditAction::make(), // status/payment updates — admin + employee

                DeleteAction::make()
                    ->visible(fn () => auth()->user()?->isAdmin() ?? false),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(fn () => auth()->user()?->isAdmin() ?? false),
                ]),
            ]);
    }
}
