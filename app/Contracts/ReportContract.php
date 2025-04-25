<?php

namespace App\Contracts;

use Carbon\Carbon;

use App\Models\User;
use App\Models\Seller;

use Illuminate\Mail\Mailable;

interface ReportContract
{
    /**
     * Sends the admin sales report for all admins for a given period.
     *
     * @param Carbon $start_date
     * @param Carbon $final_date
     *
     * @return void
     */
    public function sendAdminReportRoutine(Carbon $start_date, Carbon $final_date): void;

    /**
     * Sends the sales report for all sellers for a given period.
     *
     * @param Carbon $start_date
     * @param Carbon $final_date
     *
     * @return void
     */
    public function sendSellerReportRoutine(Carbon $start_date, Carbon $final_date): void;

    /**
     * Send an admin report email containing all sales data between the given dates.
     *
     * @param User $user
     * @param Carbon $from
     * @param Carbon $to
     *
     * @return void
     */
    public function sendAdminReport(User $user, Carbon $from, Carbon $to): void;

    /**
     * Send a seller report email containing the seller's sales data for the given period.
     *
     * @param Seller $seller
     * @param Carbon $from
     * @param Carbon $to
     *
     * @return void
     */
    public function sendSellerReport(Seller $seller, Carbon $from, Carbon $to): void;

    /**
     * Send a mailable to the given email address.
     *
     * @param string $to
     * @param Mailable $mailable
     *
     * @return void
     */
    public function sendEmail(string $to, Mailable $mailable): void;
}
