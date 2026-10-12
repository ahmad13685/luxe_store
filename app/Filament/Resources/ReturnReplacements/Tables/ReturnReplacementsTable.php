<?php

namespace App\Filament\Resources\ReturnReplacements\Tables;

use App\Models\ReturnReplacement;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ReturnReplacementsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('orderItem.product_name')->label('Product'),
                TextColumn::make('orderItem.order.order_number')->label('Order #'),
                TextColumn::make('type')->badge(),
                TextColumn::make('reason')->limit(50),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'approved', 'completed' => 'success',
                        'rejected' => 'danger',
                        default => 'warning',
                    }),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'requested' => 'Requested', 'approved' => 'Approved',
                        'rejected' => 'Rejected', 'completed' => 'Completed',
                    ]),
                SelectFilter::make('type')
                    ->options(['return' => 'Return', 'replace' => 'Replace']),
            ])
            ->recordActions([
                Action::make('approve')
                    ->visible(fn (ReturnReplacement $record) => $record->status === 'requested')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(fn (ReturnReplacement $record) => $record->update(['status' => 'approved'])),

                Action::make('reject')
                    ->visible(fn (ReturnReplacement $record) => $record->status === 'requested')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(fn (ReturnReplacement $record) => $record->update(['status' => 'rejected'])),

                Action::make('complete')
                    ->visible(fn (ReturnReplacement $record) => $record->status === 'approved')
                    ->color('gray')
                    ->action(fn (ReturnReplacement $record) => $record->update(['status' => 'completed'])),

                ViewAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
