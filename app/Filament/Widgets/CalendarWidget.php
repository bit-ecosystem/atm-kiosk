<?php

namespace App\Filament\Widgets;

use App\Models\Event;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalendarWidget extends FullCalendarWidget
{
    // protected static string $view = 'filament.widgets.calendar-widget';
    public Model|string|null $model = Event::class;

    public function fetchEvents(array $fetchInfo): array
    {
        // Fetch events from the database
        $dbEvents = Event::where('start', '>=', $fetchInfo['start'])
            ->where('end', '<=', $fetchInfo['end'])
            ->get()
            ->map(function (Event $event) {
                return [
                    'id' => $event->id,
                    'title' => $event->name,
                    'start' => $event->start,
                    'end' => $event->end,
                ];
            })
            ->toArray();

        // Fetch events from holiday.json
        $holidayEvents = $this->fetchJsonEvents(public_path('calendar/holidays.json'), $fetchInfo);

        // Fetch events from workshift.json
        $workshiftEvents = $this->fetchJsonEvents(public_path('calendar/workshifts.json'), $fetchInfo);

        // Merge all events
        return array_merge($dbEvents, $holidayEvents, $workshiftEvents);
    }

    private function fetchJsonEvents(string $filePath, array $fetchInfo): array
    {
        if (! Storage::exists($filePath)) {

            return [];

        }

        $events = json_decode(Storage::get($filePath), true);
        dd($events);

        return array_filter($events, function ($event) use ($fetchInfo) {
            return $event['start'] >= $fetchInfo['start'] && $event['end'] <= $fetchInfo['end'];
        });
    }

    public static function canView(): bool
    {
        return true;
    }

    public function config(): array
    {
        return [
            'initialView' => 'timeGridWeek', // Set the initial view to timeGridWeek
            'firstDay' => 1,
            'headerToolbar' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'dayGridMonth,timeGridWeek,timeGridDay',
            ],

        ];
    }
}
