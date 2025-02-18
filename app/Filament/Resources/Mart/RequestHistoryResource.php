<?php

namespace App\Filament\Resources\Mart;

use App\Filament\Resources\Mart\RequestHistoryResource\Pages;
use App\Models\Mart\RequestHistory;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RequestHistoryResource extends Resource
{
    protected static ?string $model = RequestHistory::class;

    protected static ?string $navigationGroup = 'Store';

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('request_id')
                    ->relationship('request', 'id')
                    ->required(),
                TextInput::make('action')->required(),
                DatePicker::make('action_date')->required(),
                Select::make('performed_by')
                    ->relationship('performedBy', 'staffid')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListRequestHistories::route('/'),
            'create' => Pages\CreateRequestHistory::route('/create'),
            'edit' => Pages\EditRequestHistory::route('/{record}/edit'),
        ];
    }
}
