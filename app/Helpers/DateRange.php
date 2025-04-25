<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateRange
{
    /**
     * Get the start and end timestamps for yesterday.
     *
     * @return array<mixed>
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
     * Get the start and end timestamps for the previous month.
     *
     * @return array<mixed>
     */
    public static function monthly(): array
    {
        $last_month = Carbon::now()->subMonthNoOverflow();

        return [
            'start' => $last_month->copy()->startOfMonth(),
            'end'   => $last_month->copy()->endOfMonth(),
        ];
    }
}
