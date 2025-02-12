<?php

namespace App\Filament\Staff\Resources\KnowledgeCatalogResource\Pages;

use App\Filament\Staff\Resources\KnowledgeCatalogResource;
use App\Models\ServiceCatalog;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListKnowledgeCatalogs extends ListRecords
{
    protected static string $resource = KnowledgeCatalogResource::class;

    public function getTitle(): string
    {
        return 'Knowledge Base';
    }

    protected function getTableQuery(): Builder
    {
        $parentId = $this->getParentId();

        return ServiceCatalog::query()->when($parentId, function ($query, $parentId) {
            return $query->where('parent_id', $parentId);
        }, function ($query) {
            return $query->whereNull('parent_id')->where('category', 'Knowledge Base');
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
            $parent = ServiceCatalog::find($parentId);
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
