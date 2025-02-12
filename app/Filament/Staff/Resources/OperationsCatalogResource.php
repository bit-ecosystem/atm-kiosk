<?php

namespace App\Filament\Staff\Resources;

use App\Filament\Staff\Resources\OperationsCatalogResource\Pages;
use App\Models\ServiceCatalog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\ColorEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;

class OperationsCatalogResource extends Resource
{
    protected static ?string $model = ServiceCatalog::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-plus';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Operations';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('category')
                    ->required(),
                Forms\Components\TextInput::make('url')
                    ->label('URL')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('title')
                    ->maxLength(255)
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->maxLength(1024)
                    ->columnSpanFull(),
                Forms\Components\ColorPicker::make('color')
                    ->hex()
                    ->hexColor(),
                Forms\Components\FileUpload::make('image')
                    ->image(),
                Forms\Components\TextInput::make('parent_id')
                    ->numeric(),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('title'),
                ColorEntry::make('color'),
                TextEntry::make('description')
                    ->columnSpanFull(),
                TextEntry::make('url')
                    ->label('URL')
                    ->columnSpanFull()
                    ->url(fn (ServiceCatalog $record): string => '#'.urlencode($record->url)),
                ImageEntry::make('image'),
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
                        // If parentId is not present, filter by category 'Operations'
                        return $query->whereNull('parent_id')
                            ->Where('category', 'Operations');
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
                'xl' => 5,
            ])
            ->actions([
                Action::make('view')
                    ->label('')
                    ->url(function ($record) {
                        if ($record->children->isEmpty()) {
                            if (str_starts_with($record->url, 'http')) {
                                return $record->url;
                            } else {
                                return route('filament.'.$record->url, $record->id);
                            }
                        } else {
                            return route('filament.staff.resources.service-catalogs.index', $record);
                        }
                    }),
            ]);
    }
    // private static function getNestedPrefix($id, $prefix = ''): string
    // {
    //     static $parents = null;
    //     if ($parents === null) {
    //         $parents = ServiceCatalog::all()->pluck('parent_id', 'id');
    //     }
    //     if ($parents[$id] ?? null) {
    //         $prefix .= self::getNestedPrefix($parents[$id], $prefix . '&nbsp;&nbsp;');
    //     }
    //     return $prefix;
    // }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOperationsCatalogs::route('/{record?}'),
        ];
    }
}
