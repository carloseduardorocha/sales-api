<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Seller;

use App\Helpers\DateRange;
use App\Helpers\ApiResponse;

use App\Exceptions\UserNotFoundException;
use App\Exceptions\SellerNotFoundException;

use App\Jobs\SendAdminReportJob;
use App\Jobs\SendSellerReportJob;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportController extends Controller
{
    /**
     * Send the admin report for the given user within the date range.
     *
     * @param int $user_id
     *
     * @return JsonResponse
     */
    public function sendAdminReport(int $user_id): JsonResponse
    {
        $admin = User::find($user_id);

        if (!$admin)
        {
            throw new UserNotFoundException();
        }

        ['start' => $start_date, 'end' => $final_date] = DateRange::daily();
        SendAdminReportJob::dispatch($admin, $start_date, $final_date)->onQueue('default');

        return ApiResponse::jsonSuccess(new JsonResource([]), Response::HTTP_OK, 'Admin report sent successfully!');
    }

    /**
     * Send the seller report for the given seller within the date range.
     *
     * @param int $seller_id
     *
     * @return JsonResponse
     */
    public function sendSellerReport(int $seller_id): JsonResponse
    {
        $seller = Seller::find($seller_id);

        if (!$seller)
        {
            throw new SellerNotFoundException();
        }

        ['start' => $start_date, 'end' => $final_date] = DateRange::daily();
        SendSellerReportJob::dispatch($seller, $start_date, $final_date)->onQueue('default');

        return ApiResponse::jsonSuccess(new JsonResource([]), Response::HTTP_OK, 'Seller report sent successfully!');
    }
}
