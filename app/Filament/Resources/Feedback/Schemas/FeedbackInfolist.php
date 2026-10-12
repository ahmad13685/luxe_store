<?php

namespace App\Filament\Resources\Feedback\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class FeedbackInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextEntry::make('customer.name')->label('Customer')->placeholder('-'),
            TextEntry::make('customer.email')->label('Email')->placeholder('-'),
            TextEntry::make('order.order_number')->label('Order #')->placeholder('-'),
            TextEntry::make('rating')->label('Rating')->badge()->placeholder('-'),
            TextEntry::make('comments')->label('Comments')->columnSpanFull(),
            TextEntry::make('created_at')->label('Submitted')->dateTime()->placeholder('-'),
        ]);
    }
}
