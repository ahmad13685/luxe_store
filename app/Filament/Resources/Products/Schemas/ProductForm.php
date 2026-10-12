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
                TextInput::make('product_code')
                    ->label('Product ID')
                    ->disabled()
                    ->dehydrated(false)
                    ->visibleOn('edit'),

                Select::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),

                TextInput::make('name')
                    ->required(),

                TextInput::make('slug')
                    ->helperText('Leave blank to generate automatically from the product name')
                    ->unique(ignoreRecord: true),

                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),

                FileUpload::make('image')
                    ->label('Product Image')
                    ->image()
                    ->required()
                    ->helperText('Every product needs its own image — without one it will show a generic placeholder on the storefront and in wishlists.')
                    ->disk('public_assets')
                    ->directory('uploads/products')
                    ->visibility('public')
                    ->getUploadedFileUsing(function (string $file): ?array {
                        $path = ltrim($file, '/');
                        $fullPath = public_path($path);

                        if (! is_file($fullPath)) {
                            return null;
                        }

                        return [
                            'name' => basename($path),
                            'size' => filesize($fullPath),
                            'type' => mime_content_type($fullPath) ?: 'application/octet-stream',
                            'url' => asset($path),
                        ];
                    })
                    ->imageEditor(),

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
