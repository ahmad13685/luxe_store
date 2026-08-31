<?php

namespace App\Filament\Resources\ReturnReplacements\Pages;

use App\Filament\Resources\ReturnReplacements\ReturnReplacementResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditReturnReplacement extends EditRecord
{
    protected static string $resource = ReturnReplacementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
