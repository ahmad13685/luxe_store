<?php

namespace App\Filament\Resources\ReturnReplacements\Pages;

use App\Filament\Resources\ReturnReplacements\ReturnReplacementResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewReturnReplacement extends ViewRecord
{
    protected static string $resource = ReturnReplacementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
