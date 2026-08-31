<?php

namespace App\Filament\Resources\ReturnReplacements\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ReturnReplacementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('order_item_id')->disabled(),
                TextInput::make('type')->disabled(),
                Textarea::make('reason')->disabled()->columnSpanFull(),

                // The only thing Admin actually changes by hand here —
                // day-to-day approvals use the Approve/Reject buttons instead.
                Select::make('status')
                    ->options([
                        'requested' => 'Requested',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        'completed' => 'Completed',
                    ])
                    ->required(),
            ]);
    }
}
