<?php

namespace App\Filament\Staff\Resources;

use App\Filament\Staff\Resources\KnowledgeMenuResource\Pages;
use App\Models\ServiceMenu;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;

class KnowledgeMenuResource extends Resource
{
    protected static ?string $model = ServiceMenu::class;

    protected static ?int $navigationSort = 8;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    protected static ?string $navigationLabel = 'Knowledge Base';

    public static function table(Table $table): Table
    {
        return $table
            ->query(function () {
                $parentId = request()->route('record');

                return ServiceMenu::query()
                    ->when($parentId, function ($query, $parentId) {
                        // If parentId is present, filter by parent_id
                        return $query->where('parent_id', $parentId);
                    }, function ($query) {
                        // If parentId is not present, filter by category 'Knowledge Base'
                        return $query->whereNull('parent_id')
                            ->Where('category', 'Knowledge Base');
                    });
            })->columns([
                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\ImageColumn::make('image')
                        ->height('50%')
                        ->width('50%'),

                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('title')
                            ->weight('bold'),
                    ]),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKnowledgeMenus::route('/'),
        ];
    }
}
