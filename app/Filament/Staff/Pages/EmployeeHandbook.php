<?php

namespace App\Filament\Staff\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Storage;

class EmployeeHandbook extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?int $navigationSort = 9;

    protected static string $view = 'filament.staff.pages.employee-handbook';

    public $handbook = [];

    public function mount()
    {
        try {
            // Check if the file exists
            if (! Storage::disk('public')->exists('policies/emp_handbook.json')) {
                throw new \Exception('File not found.');
            }

            // Get the file content
            $json = Storage::disk('public')->get('policies/emp_handbook.json');
            // dump($json); // Output the raw JSON content to debug

            // Decode the JSON content
            $this->handbook = json_decode($json, true);

            // Check for JSON errors
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Error decoding JSON: '.json_last_error_msg());
            }
        } catch (\Exception $e) {
            // Handle the error (e.g., log it, show a user-friendly message, etc.)
            $this->handbook = [];
            // dump($e->getMessage()); // Output the error message
        }

        // dump($this->handbook); // Output the contents of $handbook
    }
}
