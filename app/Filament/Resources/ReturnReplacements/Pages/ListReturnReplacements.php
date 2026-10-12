<?php

namespace App\Filament\Resources\ReturnReplacements\Pages;

use App\Filament\Resources\ReturnReplacements\ReturnReplacementResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListReturnReplacements extends ListRecords
{
    protected static string $resource = ReturnReplacementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
