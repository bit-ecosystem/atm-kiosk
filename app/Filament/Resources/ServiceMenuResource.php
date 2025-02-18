<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceMenuResource\Pages;
use App\Models\ServiceMenu;
use Filament\Forms;
use \App\Enums\PageCategoryEnum;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ServiceMenuResource extends Resource
{
    protected static ?string $model = ServiceMenu::class;

    protected static ?string $navigationGroup = 'Catalog';

    protected static ?string $navigationIcon = 'heroicon-o-bars-4';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Split::make([
                    Section::make('Menu')
                        ->schema([
                            Forms\Components\Select::make('category')
                                ->label('Category')
                                ->options(PageCategoryEnum::class)
                                ->required(),
                            Forms\Components\FileUpload::make('image')
                                ->image(),
                        ])->grow(false),
                    Section::make('Details')
                        ->schema([
                            Forms\Components\Textarea::make('title')
                                ->required(),
                            Forms\Components\Textarea::make('description')
                                ->required()
                                ->columnSpanFull(),
                            Forms\Components\Select::make('parent_id')
                                ->label('Parent')
                                ->relationship('parent', 'title')
                                ->nullable(),
                        ]),
                ])->columnSpanFull(),
                Fieldset::make('URL')
                    ->schema([
                        Forms\Components\Select::make('domain_id')
                            ->label('Domain')
                            ->relationship('domain', 'system') // Use the relationship to get the domain name
                            ->required(),
                        Forms\Components\TextInput::make('path'),
                        Forms\Components\TextInput::make('param'),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                //Tables\Columns\TextColumn::make('category')
                //    ->searchable(),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->alignLeft(),
                Tables\Columns\TextColumn::make('full_url')
                    ->label('Link')
                    ->getStateUsing(function ($record) {
                        return '<' . $record->domain->system . '>' . $record->path . $record->param;
                    })
                    ->searchable()
                    ->sortable()
                    ->color('gray')
                    ->alignLeft(),
                Tables\Columns\TextColumn::make('parent_id')
                    ->numeric()
                    ->sortable(),

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
            ])->defaultGroup('category');
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
            'index' => Pages\ListServiceMenus::route('/'),
            'create' => Pages\CreateServiceMenu::route('/create'),
            'edit' => Pages\EditServiceMenu::route('/{record}/edit'),
        ];
    }
}
