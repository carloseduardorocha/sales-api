<?php

use App\Helpers\Report;
use App\Helpers\DateRange;

use App\Services\ReportService;

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function() {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/** START daily routine */
Schedule::call(function() {
    ['start' => $start_date, 'end' => $final_date] = DateRange::daily();
    Report::getSalesByPeriod($start_date, $final_date);
})->dailyAt('00:00');

Schedule::call(function() {
    ['start' => $start_date, 'end' => $final_date] = DateRange::daily();
    (new ReportService())->sendAdminReportRoutine($start_date, $final_date);
})->dailyAt('01:00');

Schedule::call(function() {
    ['start' => $start_date, 'end' => $final_date] = DateRange::daily();
    (new ReportService())->sendSellerReportRoutine($start_date, $final_date);
})->dailyAt('01:30');
/** END daily routine */

/** START monthly routine */
Schedule::call(function() {
    ['start' => $start_date, 'end' => $final_date] = DateRange::monthly();
    Report::getSalesByPeriod($start_date, $final_date);
})->monthlyOn(1, '00:00');

Schedule::call(function() {
    ['start' => $start_date, 'end' => $final_date] = DateRange::monthly();
    (new ReportService())->sendAdminReportRoutine($start_date, $final_date);
})->monthlyOn(1, '02:00');

Schedule::call(function() {
    ['start' => $start_date, 'end' => $final_date] = DateRange::monthly();
    (new ReportService())->sendSellerReportRoutine($start_date, $final_date);
})->monthlyOn(1, '02:30');
/** END monthly routine */
