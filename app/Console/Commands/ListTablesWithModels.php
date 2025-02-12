<?php

namespace App\Console\Commands;

use App\Services\ModelTableMapper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ListTablesWithModels extends Command
{
    protected $signature = 'bites:list-models';

    protected $description = 'List all tables with their associated models';

    public function handle()
    {
        $mapper = new ModelTableMapper;
        $tablesWithModels = $mapper->getTablesWithModels();

        $this->info('Tables with their associated models:');
        foreach ($tablesWithModels as $table => $model) {
            $this->line("Table: $table, Model: $model");
        }
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
