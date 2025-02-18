<?php

namespace App\Filament\Staff\Resources\ServiceMenuResource\Pages;

use App\Filament\Staff\Resources\ServiceMenuResource;
use App\Models\ServiceMenu;
use Filament\Resources\Pages\ListRecords;

class ListServiceMenus extends ListRecords
{
    protected static string $resource = ServiceMenuResource::class;

    public function getTitle(): string
    {
        return 'Staff Self Service';
    }

    protected function getParentId()
    {
        return request()->route('record');
    }

    public function getBreadcrumbs(): array
    {
        $breadcrumbs = [
        ];

        if ($parentId = $this->getParentId()) {
            $parent = ServiceMenu::find($parentId);
            while ($parent) {
                $breadcrumbs[$parent->id] = $parent->title;
                $parent = $parent->parent;

            }
        }

        $breadcrumbs['List'] = null;

        return $breadcrumbs;
    }
}
