<?php

namespace App\Filament\Staff\Resources;

use App\Filament\Staff\Resources\ServiceMenuResource\Pages;
use App\Models\ServiceMenu;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;

class ServiceMenuResource extends Resource
{
    protected static ?string $model = ServiceMenu::class;

    protected static ?string $navigationIcon = 'heroicon-o-cursor-arrow-ripple';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationLabel = 'Self Service';

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

                return ServiceMenu::query()
                    ->when($parentId, function ($query, $parentId) {
                        // If parentId is present, filter by parent_id
                        return $query->where('parent_id', $parentId);
                    }, function ($query) {
                        // If parentId is not present, filter by category 'Staff Self Service'
                        return $query->whereNull('parent_id')
                            ->where('category', 'Staff Self Service');
                    });
            })->columns([
                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\ImageColumn::make('image')
                        ->height('50%')
                        ->width('50%')
                        ->extraAttributes([
                            'style' => 'display: flex; justify-content: center; align-items: center;']),

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
                            'style' => "background-color: {$record->color}; padding: 5px; border-radius: 5px;",
                        ];
                    }),
            ])
            ->filters([
                // Add filters if needed
            ])
            ->contentGrid([
                'md' => 3,
                'xl' => 5,
            ])
            ->paginated(false)
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
                            return route('filament.staff.resources.service-menus.index', $record);
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
            'index' => Pages\ListServiceMenus::route('/{record?}'),
        ];
    }
}
