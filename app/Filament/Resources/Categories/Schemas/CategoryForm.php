<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->label('2-digit category code')
                    ->length(2)
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->rule('regex:/^[0-9]{2}$/')
                    ->helperText('Exactly 2 digits, e.g. 01, 12.'),

                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }
}
