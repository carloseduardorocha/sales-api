<?php

namespace App\Contracts;

use Carbon\Carbon;

use App\Models\User;
use App\Models\Seller;

use Illuminate\Mail\Mailable;

interface ReportContract
{
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
