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
            $relativePath = str_replace(['/', '.php'], ['\\', ''], $file->getRelativePathname());
            $class = $namespace.$relativePath;

            if (class_exists($class) && ! $this->usesSushiTrait($class)) {
                $models[] = $class;
            }
        }

        return $models;
    }

    private function usesSushiTrait($class)
    {
        $traits = class_uses($class);

        return in_array('Sushi', $traits);
    }
}
