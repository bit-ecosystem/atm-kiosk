<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class ModelTableMapper
{
    public function getTablesWithModels()
    {
        $modelsPath = app_path('Models');
        $models = $this->getModels($modelsPath);

        $tablesWithModels = [];
        foreach ($models as $model) {
            $table = (new $model)->getTable();
            $tablesWithModels[$table] = $model;
        }

        return $tablesWithModels;
    }

    private function getModels($path)
    {
        $models = [];
        $files = File::allFiles($path);

        foreach ($files as $file) {
            $namespace = 'App\\Models\\';
            $class = $namespace.str_replace(['/', '.php'], ['\\', ''], $file->getRelativePathname());

            if (class_exists($class)) {
                $models[] = $class;
            }
        }

        return $models;
    }
}
