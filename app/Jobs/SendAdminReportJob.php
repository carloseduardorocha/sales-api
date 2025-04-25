<?php

namespace App\Jobs;

use Carbon\Carbon;

use App\Models\User;
use App\Services\ReportService;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendAdminReportJob implements ShouldQueue
{
    use Queueable;

    protected User $admin;
    protected Carbon $start_date;
    protected Carbon $final_date;

    /**
     * Criação do Job.
     *
     * @param User $admin
     * @param Carbon $start_date
     * @param Carbon $final_date
     */
    public function __construct(User $admin, Carbon $start_date, Carbon $final_date)
    {
        $this->admin      = $admin;
        $this->start_date = $start_date;
        $this->final_date = $final_date;
    }

    /** Execute the job. */
    public function handle(): void
    {
        (new ReportService())->sendAdminReport($this->admin, $this->start_date, $this->final_date);
    }
}
