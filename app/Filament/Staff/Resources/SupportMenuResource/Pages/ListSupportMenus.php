<?php

namespace App\Filament\Staff\Resources\SupportMenuResource\Pages;

use App\Filament\Staff\Resources\SupportMenuResource;
use App\Models\ServiceMenu;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListSupportMenus extends ListRecords
{
    protected static string $resource = SupportMenuResource::class;

    public function getTitle(): string
    {
        return 'Support';
    }

    protected function getTableQuery(): Builder
    {
        $parentId = $this->getParentId();

        return ServiceMenu::query()->when($parentId, function ($query, $parentId) {
            return $query->where('parent_id', $parentId);
        }, function ($query) {
            return $query->whereNull('parent_id')->where('category', 'Support');
        });
    }

    protected function getParentId()
    {
        return request()->route('record');
    }

    public function getBreadcrumbs(): array
    {
        $breadcrumbs = [
            // 'service-catalogs' => 'Service Catalog'//route('filament.staff.resources.service-catalogs.index'),
        ];

        if ($parentId = $this->getParentId()) {
            $parent = ServiceMenu::find($parentId);
            dump($parent->children);
            while ($parent) {
                $breadcrumbs[$parent->id] = $parent->title; // route('filament.staff.resources.service-catalogs.index', $parent);
                $parent = $parent->parent;

            }
        }

        $breadcrumbs['List'] = null;

        return $breadcrumbs;
    }
}
