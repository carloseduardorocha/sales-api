<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateRange
{
    /**
     * Get the start and end timestamps for yesterday.
     *
     * @return array{
     *     start: \Carbon\Carbon,
     *     end: \Carbon\Carbon
     * }
     */
    public static function daily(): array
    {
        $yesterday = Carbon::now()->subDay();

        return [
            'start' => $yesterday->copy()->startOfDay(),
            'end'   => $yesterday->copy()->endOfDay(),
        ];
    }

    /**
     * Get the start and end timestamps for the last third days.
     *
     * @return array{
     *     start: \Carbon\Carbon,
     *     end: \Carbon\Carbon
     * }
     */
    public static function monthly(): array
    {
        $now = Carbon::now();

        return [
            'start' => $now->copy()->subDays(30),
            'end'   => $now,
        ];
    }
}
