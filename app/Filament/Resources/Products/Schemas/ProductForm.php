<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Auto-generated in Product::booted() — read-only, hidden on create.
                TextInput::make('product_code')
                    ->label('Product ID')
                    ->disabled()
                    ->dehydrated(false)
                    ->visibleOn('edit'),

                Select::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->required()
                    ->searchable(),

                TextInput::make('name')
                    ->required(),

                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true),

                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),

                FileUpload::make('image')
                    ->image(),

                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->default(0.0)
                    ->prefix('Rs.'),

                TextInput::make('stock')
                    ->required()
                    ->numeric()
                    ->default(0),

                Toggle::make('is_active')
                    ->required()
                    ->default(true),
            ]);
    }
}
