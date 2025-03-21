<?php

namespace App\Filament\Editor\Resources\EipResource\Pages;

use App\Filament\Editor\Resources\EipResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\DB;


class CreateEip extends CreateRecord
{
    protected static string $resource = EipResource::class;

    protected function getFormSchema(): array
    {
        // Fetch options directly from the database
        $opt = DB::table('options')->pluck('type', 'list'); // Adjust 'your_table_name', 'name', and 'id' to your table and column names

        return [
            Select::make('process')
                ->label('Select an Option')
                ->options($opt)
                ->required(),
        ];
    }
    
    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
