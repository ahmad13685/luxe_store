<?php

namespace App\Filament\Resources\Feedback\Schemas;

use Filament\Forms\Components\Placeholder;
use Filament\Schemas\Schema;

class FeedbackForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Placeholder::make('message')
                ->label('Feedback')
                ->content('Feedback is submitted by customers and is read-only in the admin panel.'),
        ]);
    }
}
