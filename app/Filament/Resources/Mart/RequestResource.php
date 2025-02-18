<?php

namespace App\Filament\Resources\Mart;

use App\Filament\Resources\Mart\RequestResource\Pages;
use App\Models\Mart\Request;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RequestResource extends Resource
{
    protected static ?string $model = Request::class;

    protected static ?string $navigationGroup = 'Store';

    protected static ?string $navigationIcon = 'heroicon-o-cursor-arrow-ripple';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('org_staff_id')
                    ->relationship('orgStaff', 'staffid')
                    ->required(),
                Select::make('asset_id')
                    ->relationship('asset', 'description')
                    ->nullable(),
                Select::make('request_type')->options([
                    'Asset' => 'Asset',
                    'Leave' => 'Leave',
                    'Training' => 'Training',
                    'Travel' => 'Travel',
                    'Expense' => 'Expense',
                    'IT Support' => 'IT Support',
                ])->required(),
                DatePicker::make('request_date')->required(),
                Select::make('status')->options([
                    'Pending' => 'Pending',
                    'Approved' => 'Approved',
                    'Denied' => 'Denied',
                ])->required(),
                Select::make('approval_layer_1_status')->options([
                    'Pending' => 'Pending',
                    'Approved' => 'Approved',
                    'Denied' => 'Denied',
                ])->required(),
                Select::make('approval_layer_2_status')->options([
                    'Pending' => 'Pending',
                    'Approved' => 'Approved',
                    'Denied' => 'Denied',
                ])->required(),
                Select::make('approval_layer_3_status')->options([
                    'Pending' => 'Pending',
                    'Approved' => 'Approved',
                    'Denied' => 'Denied',
                ])->required(),
                Select::make('final_status')->options([
                    'Pending' => 'Pending',
                    'Approved' => 'Approved',
                    'Denied' => 'Denied',
                ])->required(),
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
            'index' => Pages\ListRequests::route('/'),
            'create' => Pages\CreateRequest::route('/create'),
            'edit' => Pages\EditRequest::route('/{record}/edit'),
        ];
    }
}
