<?php

namespace App\Services;

use Carbon\Carbon;

use App\Helpers\Report;

use App\Models\User;
use App\Models\Seller;

use App\Contracts\ReportContract;
use App\Mail\AdminReportMail;
use App\Mail\SellerReportMail;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class ReportService implements ReportContract
{
    public function sendAdminReport(User $user, Carbon $from, Carbon $to): void
    {
        $reports = Report::getAdminReport($from, $to);
        $this->sendEmail($user->email, new AdminReportMail($reports));
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
