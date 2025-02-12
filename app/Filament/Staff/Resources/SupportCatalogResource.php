<?php

namespace App\Filament\Staff\Resources;

use App\Filament\Staff\Resources\SupportCatalogResource\Pages;
use App\Models\ServiceCatalog;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;

class SupportCatalogResource extends Resource
{
    protected static ?string $model = ServiceCatalog::class;

    protected static ?string $navigationIcon = 'heroicon-o-hand-raised';

    protected static ?string $navigationLabel = 'Support';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(function () {
                $parentId = request()->route('record');

                return ServiceCatalog::query()
                    ->when($parentId, function ($query, $parentId) {
                        // If parentId is present, filter by parent_id
                        return $query->where('parent_id', $parentId);
                    }, function ($query) {
                        // If parentId is not present, filter by category 'Support'
                        return $query->whereNull('parent_id')
                            ->Where('category', 'Support');
                    });
            })->columns([
                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\ImageColumn::make('image')
                        ->height('50%')
                        ->width('50%'),

                    //  Tables\Columns\Layout\Stack::make([
                    Tables\Columns\TextColumn::make('title')
                        ->weight('bold')
                        ->extraAttributes([
                            'style' => 'text-align: center;',
                        ]),
                    //    ),
                ])->space(3)
                    ->alignment('center')
                    ->extraAttributes(function ($record) {
                        return [
                            'title' => "{$record->description}", // Tooltip content
                            'style' => "background-color: {$record->color}; padding: 10px; border-radius: 5px;",
                        ];
                    }),
            ])
            ->filters([
                // Add filters if needed
            ])
            ->contentGrid([
                'md' => 3,
                'xl' => 4,
            ])
            ->actions([
                Action::make('view')
                    ->label('')
                    ->url(function ($record) {
                        if ($record->children->isEmpty()) {
                            if (str_starts_with($record->url, 'http')) {
                                return $record->url;
                            } else {
                                return rtrim(config('app.url'), '/').'/'.ltrim($record->url, '/');
                            }
                        } else {
                            return route('filament.staff.resources.service-catalogs.index', $record);
                        }
                    }),
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
            'index' => Pages\ListSupportCatalogs::route('/'),
        ];
    }
}
