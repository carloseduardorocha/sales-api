<?php

namespace Tests\Unit\Helpers;

use App\Helpers\DateRange;
use Carbon\Carbon;
use Tests\TestCase;

class DateRangeTest extends TestCase
{
    public function test_daily_returns_yesterdays_start_and_end(): void
    {
        Carbon::setTestNow('2024-04-27 15:00:00');

        $range = DateRange::daily();

        $expectedStart = Carbon::yesterday()->startOfDay();
        $expectedEnd   = Carbon::yesterday()->endOfDay();

        $this->assertTrue($range['start']->equalTo($expectedStart));
        $this->assertTrue($range['end']->equalTo($expectedEnd));

        Carbon::setTestNow();
    }

    public function test_monthly_returns_last_thirty_days(): void
    {
        Carbon::setTestNow('2024-04-27 15:00:00');

        $range = DateRange::monthly();

        $expectedStart = Carbon::now()->copy()->subDays(30);
        $expectedEnd   = Carbon::now();

        $this->assertTrue($range['start']->equalTo($expectedStart));
        $this->assertTrue($range['end']->equalTo($expectedEnd));

        Carbon::setTestNow();
    }
}
