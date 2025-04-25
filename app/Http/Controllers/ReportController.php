<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Seller;

use App\Helpers\DateRange;
use App\Helpers\ApiResponse;

use App\Contracts\ReportContract;

use App\Exceptions\UserNotFoundException;
use App\Exceptions\SellerNotFoundException;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;


class ReportController extends Controller
{
    public function __construct(private ReportContract $report_service)
    {
    }

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
        $this->report_service->sendAdminReport($admin, $start_date, $final_date); // @phpstan-ignore-line

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
        $this->report_service->sendSellerReport($seller, $start_date, $final_date); // @phpstan-ignore-line

        return ApiResponse::jsonSuccess(new JsonResource([]), Response::HTTP_OK, 'Seller report sent successfully!');
    }
}
