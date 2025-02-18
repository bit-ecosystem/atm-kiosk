<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

// Load JSON data
$jsonPath = storage_path('app/public/about.json');
$jsonData = File::get($jsonPath);
$data = json_decode($jsonData, true);

// Load JSON data
$jsonPath = storage_path('app/public/hub.json');
$jsonData = File::get($jsonPath);
$data1 = json_decode($jsonData, true);

// Fetch JSON data from GitHub
$hubJsonUrl = 'https://raw.githubusercontent.com/bit-ecosystem/portal/main/hub.json';
$response = Http::get($hubJsonUrl);
$data2 = json_decode($response->body(), true);
?>

<div class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
    <div class="relative w-full h-auto overflow-hidden">
        <img src="{{ asset('storage/about/green-sea-turtle.png') }}" alt="Background Image" class="w-full h-auto" />
    </div>
    <h1 class="mt-8 text-2xl font-medium text-gray-900 dark:text-white">
        {{ $data['title'] }}
    </h1>
    <p class="mt-6 text-gray-500 dark:text-gray-400 leading-relaxed">
        {{ $data['brief'] }}
    </p>
</div>
<div class="bg-gray-200 dark:bg-gray-800 bg-opacity-25 grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 p-6 lg:p-8 border-b border-gray-200 dark:border-gray-700">
    @foreach ($data['topics'] as $entry)
        <div>
            <div class="flex items-center">
                {!! $entry['icon'] !!}
                <h2 class="ms-3 text-xl font-semibold text-gray-900 dark:text-white">
                    <a href="{{ $entry['link'] }}">{{ $entry['title'] }}</a>
                </h2>
            </div>

            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                {!! $entry['brief'] !!}
            </p>
        </div>
    @endforeach
</div>
<div class="bg-gray-200 dark:bg-gray-800 bg-opacity-25 grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 p-6 lg:p-8">
    @foreach ($data1 as $entry)
        <div>
            <div class="flex items-center">
                {!! $entry['icon'] !!}
                <h2 class="ms-3 text-xl font-semibold text-gray-900 dark:text-white">
                    <a href="{{ $entry['link'] }}">{{ $entry['title'] }}</a>
                </h2>
            </div>
        </div>
    @endforeach
</div>
