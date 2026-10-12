<?php

namespace App\Filament\Resources\ReturnReplacements;

use App\Filament\Resources\ReturnReplacements\Pages\CreateReturnReplacement;
use App\Filament\Resources\ReturnReplacements\Pages\EditReturnReplacement;
use App\Filament\Resources\ReturnReplacements\Pages\ListReturnReplacements;
use App\Filament\Resources\ReturnReplacements\Pages\ViewReturnReplacement;
use App\Filament\Resources\ReturnReplacements\Schemas\ReturnReplacementForm;
use App\Filament\Resources\ReturnReplacements\Schemas\ReturnReplacementInfolist;
use App\Filament\Resources\ReturnReplacements\Tables\ReturnReplacementsTable;
use App\Models\ReturnReplacement;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ReturnReplacementResource extends Resource
{
    protected static ?string $model = ReturnReplacement::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'reason';

    public static function shouldRegisterNavigation(): bool
{
    return auth()->user()?->isAdmin() ?? false;
}
    public static function form(Schema $schema): Schema
    {
        return ReturnReplacementForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ReturnReplacementInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ReturnReplacementsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListReturnReplacements::route('/'),
            'create' => CreateReturnReplacement::route('/create'),
            'view' => ViewReturnReplacement::route('/{record}'),
            'edit' => EditReturnReplacement::route('/{record}/edit'),
        ];
    }
}
