<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ListPanels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bites:list-panels';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all Filament panels and their paths';

    public function handle()
    {
        $panelFiles = File::allFiles(app_path('Providers/Filament'));

        $panelClasses = collect($panelFiles)->map(function ($file) {
            return 'App\\Providers\\Filament\\'.str_replace(
                ['/', '.php'],
                ['\\', ''],
                $file->getRelativePathname()
            );
        });

        $panelPaths = [];

        foreach ($panelFiles as $file) {
            $content = File::get($file);
            if (preg_match("/->path\('([^']+)'\)/", $content, $matches)) {
                $panelPath = $matches[1];
                $panelPaths[] = $panelPath;
                $this->info($file->getFilename().' - '.$panelPath);
            }
        }
        // Generate Blade template content for panel-links.blade.php
        $bladeContent = '';
        foreach ($panelPaths as $panelPath) {
            $capitalizedPanelPath = ucfirst($panelPath).' Panel';
            $bladeContent .= "        <div class=\"hidden space-x-8 sm:-my-px sm:ms-10 sm:flex\">\n";
            $bladeContent .= "            <x-nav-link href=\"{{ route('filament.{$panelPath}.pages.dashboard') }}\">\n";
            $bladeContent .= "                {{ __('{$capitalizedPanelPath}') }}\n";
            $bladeContent .= "            </x-nav-link>\n";
            $bladeContent .= "        </div>\n";
        }
        $bladeContent .= "        <div class=\"hidden space-x-8 sm:-my-px sm:ms-10 sm:flex\">\n";
        $bladeContent .= "            <x-nav-link href=\"{{ route('about') }}\">\n";
        $bladeContent .= "                About\n";
        $bladeContent .= "            </x-nav-link>\n";
        $bladeContent .= "        </div>\n";
        // Save the content to panel-links.blade.php
        File::put(resource_path('views/components/panel-links.blade.php'), $bladeContent);

        $this->info('Panel links have been generated and saved to resources/views/components/panel-links.blade.php');

    }
}
