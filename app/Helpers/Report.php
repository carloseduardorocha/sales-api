<?php

namespace App\Helpers;

use Carbon\Carbon;

use App\Models\Sale;
use App\Models\Seller;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;

class Report
{
    /**
     * Retrieves and caches all sales between two dates, grouped by seller ID.
     *
     * @param Carbon $from
     * @param Carbon $to
     *
     * @return Collection Grouped sales by seller_id
     */
    public static function getSalesByPeriod(Carbon $from, Carbon $to): Collection // @phpstan-ignore-line
    {
        $cache_key = CacheKey::sanitize('sales_' . $from->format('Ymd_His') . '_' . $to->format('Ymd_His'));
        $sales     = Cache::get($cache_key, null);

        if (empty($sales))
        {
            $sales = Sale::whereBetween(Sale::SALE_DATE, [$from, $to])->get()->groupBy(Sale::SELLER_ID);
            Cache::add($cache_key, $sales, Carbon::now()->addDay());
        }

        return $sales; // @phpstan-ignore-line
    }

    /**
     * Generates a sales report for a specific seller within a date range.
     *
     * @param Seller $seller
     * @param Carbon $from
     * @param Carbon $to
     * @param Collection<int, Sale>|null $cached_sales
     *
     * @return array<mixed>
     */
    public static function getSellerReport(Seller $seller, Carbon $from, Carbon $to, Collection|null $cached_sales = null): array
    {
        $cached_sales ??= self::getSalesByPeriod($from, $to);
        $sales = $cached_sales->get($seller->id, collect());

        return [
            'start_date'  => $from->toFormattedDateString(),
            'final_date'  => $to->toFormattedDateString(),
            'seller'      => $seller,
            'sales_count' => $sales->count(),
            'sales_value' => $sales->sum('amount'),
            'commission'  => $sales->sum('commission'),
            'sales'       => $sales,
        ];
    }

    /**
     * Generates a complete sales report for all sellers, including totals.
     *
     * @param Carbon $from
     * @param Carbon $to
     *
     * @return array<mixed>
     */
    public static function getAdminReport(Carbon $from, Carbon $to): array
    {
        $cached_sales = self::getSalesByPeriod($from, $to);
        $sellers      = Seller::whereIn(Seller::ID, $cached_sales->keys())->get()->keyBy(Seller::ID);

        $sellers_reports = collect();

        foreach ($sellers as $i => $seller)
        {
            $sellers_reports->push(self::getSellerReport($sellers[$i], $from, $to, $cached_sales)); // @phpstan-ignore-line
        }

        return [
            'start_date'  => $from->toFormattedDateString(),
            'final_date'  => $to->toFormattedDateString(),
            'sales_count' => $sellers_reports->sum('sales_count'),
            'sales_value' => $sellers_reports->sum('sales_value'),
            'commission'  => $sellers_reports->sum('commission'),
            'sellers'     => $sellers_reports->values()->toArray(),
        ];
    }
}
