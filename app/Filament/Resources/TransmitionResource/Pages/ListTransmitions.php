<?php

namespace App\Filament\Resources\TransmitionResource\Pages;

use App\Filament\Resources\TransmitionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTransmitions extends ListRecords
{
    protected static string $resource = TransmitionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
