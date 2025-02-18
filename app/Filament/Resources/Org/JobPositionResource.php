<?php

namespace App\Filament\Resources\Org;

use App\Filament\Resources\Org\JobPositionResource\Pages;
use App\Models\Org\JobPosition;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class JobPositionResource extends Resource
{
    protected static ?string $navigationGroup = 'Organization';

    protected static ?string $model = JobPosition::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('org_staff_id')
                    ->numeric(),
                Forms\Components\TextInput::make('reports_to_id')
                    ->numeric(),
                Forms\Components\TextInput::make('unique_id')
                    ->required(),
                Forms\Components\TextInput::make('title')
                    ->required(),
                Forms\Components\TextInput::make('description')
                    ->required(),
                Forms\Components\TextInput::make('emasco'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('org_staff_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reports_to_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('unique_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable(),
                Tables\Columns\TextColumn::make('emasco')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListJobPositions::route('/'),
            'create' => Pages\CreateJobPosition::route('/create'),
            'edit' => Pages\EditJobPosition::route('/{record}/edit'),
        ];
    }
}
