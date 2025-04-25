<?php

namespace App\Services;

use Carbon\Carbon;

use App\Helpers\Report;

use App\Models\User;
use App\Models\Seller;

use App\Contracts\ReportContract;

use App\Jobs\SendAdminReportJob;
use App\Jobs\SendSellerReportJob;

use App\Mail\AdminReportMail;
use App\Mail\SellerReportMail;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class ReportService implements ReportContract
{
    public function sendAdminReportRoutine(Carbon $start_date, Carbon $final_date): void
    {
        $admins = User::all();

        $admins->each(
            fn ($admin) => SendAdminReportJob::dispatch($admin, $start_date, $final_date)
        );
    }

    public function sendSellerReportRoutine(Carbon $start_date, Carbon $final_date): void
    {
        $sellers = Seller::all();

        $sellers->each(
            fn ($seller) => SendSellerReportJob::dispatch($seller, $start_date, $final_date)
        );
    }

    public function sendAdminReport(User $admin, Carbon $from, Carbon $to): void
    {
        $reports = Report::getAdminReport($from, $to);
        $this->sendEmail($admin->email, new AdminReportMail($reports));
    }

    public function sendSellerReport(Seller $seller, Carbon $from, Carbon $to): void
    {
        $report = Report::getSellerReport($seller, $from, $to);
        $this->sendEmail($seller->email, new SellerReportMail($report));
    }

    public function sendEmail(string $to, Mailable $mailable): void
    {
        Mail::to($to)->send($mailable);
    }
}
