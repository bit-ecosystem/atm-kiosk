<?php

namespace App\Filament\Staff\Resources\ServiceCatalogResource\Pages;

use App\Filament\Staff\Resources\ServiceCatalogResource;
use App\Models\ServiceCatalog;
use Filament\Resources\Pages\ListRecords;

class ListServiceCatalogs extends ListRecords
{
    protected static string $resource = ServiceCatalogResource::class;

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
            // 'service-catalogs' => 'Service Catalog'//route('filament.staff.resources.service-catalogs.index'),
        ];

        if ($parentId = $this->getParentId()) {
            $parent = ServiceCatalog::find($parentId);
            while ($parent) {
                $breadcrumbs[$parent->id] = $parent->title; // route('filament.staff.resources.service-catalogs.index', $parent);
                $parent = $parent->parent;

            }
        }

        $breadcrumbs['List'] = null;

        return $breadcrumbs;
    }
}
