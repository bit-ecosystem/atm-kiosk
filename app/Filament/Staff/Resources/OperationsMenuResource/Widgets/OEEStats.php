<?php

namespace App\Filament\Staff\Resources\OperationsMenuResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Storage;

class OEEStats extends BaseWidget
{
    protected function getStats(): array
    {
        // Check if the file exists
        if (! Storage::disk('public')->exists('oee.json')) {
            throw new \Exception('File not found.');
        }

        // Get the file content
        $jsonData = Storage::disk('public')->get('oee.json');
        // dump($json); // Output the raw JSON content to debug

        //        $jsonData = Storage::get($jsonFile);

        // Step 3: Decode the JSON data into a PHP array
        $data = json_decode($jsonData, true);

        // Step 4: Check if data is valid
        if ($data === null) {
            return [
                Stat::make('Error', 'Failed to decode JSON')
                    ->description('Please check the JSON file format')
                    ->color('danger'),
            ];
        }

        // Step 5: Extract data and create stats
        $totalOperations = $data['total_operations'] ?? 0;
        $averageEfficiency = $data['average_efficiency'] ?? 0;
        $totalDowntime = $data['total_downtime'] ?? 0;

        return [
            Stat::make('Total Operations', $totalOperations)
                ->description('Total number of operations')
                ->descriptionIcon('heroicon-o-clock')
                ->color('primary'),

            Stat::make('Average Efficiency', number_format($averageEfficiency, 2).'%')
                ->description('Average efficiency of operations')
                ->descriptionIcon('heroicon-o-clock')
                ->color('success'),

            Stat::make('Total Downtime', $totalDowntime.' hours')
                ->description('Total downtime in hours')
                ->descriptionIcon('heroicon-o-clock')
                ->color('danger'),
        ];
    }
}
