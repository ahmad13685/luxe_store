<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('order_number')
                    ->disabled(),

                Select::make('customer_id')
                    ->relationship('customer', 'name')
                    ->disabled(),

                Select::make('status')
                    ->options([
                        'Pending' => 'Pending',
                        'Payment Verified' => 'Payment Verified',
                        'Processing' => 'Processing',
                        'Packed' => 'Packed',
                        'Dispatched' => 'Dispatched',
                        'Out For Delivery' => 'Out For Delivery',
                        'Delivered' => 'Delivered',
                        'Cancelled' => 'Cancelled',
                    ])
                    ->required(),
                    // The one field both Admin and Employee are meant to edit.

                Select::make('payment_status')
                    ->options(['pending' => 'Pending', 'cleared' => 'Cleared', 'failed' => 'Failed'])
                    ->required(),

                TextInput::make('payment_method')->disabled(),
                TextInput::make('card_last4')->label('Card (last 4)')->disabled(),
                TextInput::make('cheque_number')->disabled(),

                TextInput::make('subtotal')->numeric()->prefix('Rs.')->disabled(),
                TextInput::make('shipping_fee')->numeric()->prefix('Rs.')->disabled(),
                TextInput::make('total_amount')->numeric()->prefix('Rs.')->disabled(),
            ]);
    }
}
