<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->label('Category name')
                ->required()
                ->maxLength(255),

            TextInput::make('code')
                ->label('Category code')
                ->length(2)
                ->nullable()
                ->disabled(fn (string $operation): bool => $operation === 'edit')
                ->dehydrated(fn (string $operation): bool => $operation === 'create')
                ->unique(ignoreRecord: true)
                ->rule('regex:/^[0-9]{2}$/')
                ->helperText('Optional. If left empty, the next 2-digit code is generated automatically.'),
        ]);
    }
}
