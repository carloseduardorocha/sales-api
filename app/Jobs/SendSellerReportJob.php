<?php

namespace App\Jobs;

use Carbon\Carbon;

use App\Models\Seller;
use App\Services\ReportService;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendSellerReportJob implements ShouldQueue
{
    use Queueable;

    protected Seller $seller;
    protected Carbon $start_date;
    protected Carbon $final_date;

    /**
     * Criação do Job.
     *
     * @param Seller $seller
     * @param Carbon $start_date
     * @param Carbon $final_date
     */
    public function __construct(Seller $seller, Carbon $start_date, Carbon $final_date)
    {
        $this->seller     = $seller;
        $this->start_date = $start_date;
        $this->final_date = $final_date;
    }

    /** Execute the job. */
    public function handle(): void
    {
        (new ReportService())->sendSellerReport($this->seller, $this->start_date, $this->final_date);
    }
}
