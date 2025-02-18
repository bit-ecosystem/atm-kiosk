<?php

namespace App\Filament\Staff\Resources\OperationsMenuResource\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Storage;

class OEEChart extends ChartWidget
{
    protected static ?string $heading = 'OEE Trending';

    protected function getData(): array
    {  // Step 1: Check if the file exists
        if (! Storage::disk('public')->exists('operations/oee.json')) {
            throw new \Exception('File not found.');
        }

        // Step 2: Get the file content and decode
        $jsonData = Storage::disk('public')->get('operations/oee.json');

        $data = json_decode($jsonData, true);

        // Step 3: Check if data is valid
        if ($data === null) {
            return [
                'datasets' => [],
                'labels' => [],
            ];
        }

        // Step 4: Extract data for the chart
        $labels = $data['weeks'] ?? [];
        $totalOperations = $data['total_operations'] ?? [];
        $averageEfficiency = $data['average_efficiency'] ?? [];
        $totalDowntime = $data['total_downtime'] ?? [];

        return [
            'datasets' => [
                [
                    'label' => 'Total Operations',
                    'data' => $totalOperations,
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                ],
                [
                    'label' => 'Average Efficiency',
                    'data' => $averageEfficiency,
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                ],
                [
                    'label' => 'Total Downtime',
                    'data' => $totalDowntime,
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
