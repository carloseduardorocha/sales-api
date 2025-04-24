<?php

namespace App\Helpers;

use App\Models\Sale as Model;
use Illuminate\Database\Eloquent\Collection;

class Sale
{
    /**
     * Get all sales.
     *
     * @return Collection<int, Model>
     */
    public static function all(): Collection
    {
        return Model::all();
    }

    /**
     * Get a sale by its ID.
     *
     * @param int $id
     * @return Model|null
     */
    public static function get(int $id): ?Model
    {
        return Model::find($id);
    }

    /**
     * Get all sales by a specific seller ID.
     *
     * @param int $seller_id
     * @return Collection<int, Model>
     */
    public static function getBySellerId(int $seller_id): Collection
    {
        return Model::where(Model::SELLER_ID, $seller_id)->get();
    }

    /**
     * Create a new sale.
     *
     * @param int $seller_id
     * @param float $amount
     * @param string $sale_date (format: Y-m-d)
     *
     * @return Model
     */
    public static function create(int $seller_id, float $amount, string $sale_date): Model
    {
        return Model::create([
            Model::SELLER_ID  => $seller_id,
            Model::AMOUNT     => $amount,
            Model::COMMISSION => round($amount * 0.085, 2),
            Model::SALE_DATE  => $sale_date,
        ]);
    }

    /**
     * Update a sale by its ID.
     *
     * @param int $id
     * @param float $amount
     * @param string $sale_date
     *
     * @return bool
     */
    public static function update(int $id, int $seller_id, float $amount, string $sale_date): bool
    {
        $sale = self::get($id);

        if (!$sale)
        {
            return false;
        }

        $sale->seller_id  = $seller_id;
        $sale->amount     = $amount;
        $sale->commission = round($amount * 0.085, 2);
        $sale->sale_date  = $sale_date;

        return $sale->save();
    }

    /**
     * Delete a sale by its ID.
     *
     * @param int $id
     * @return bool
     */
    public static function delete(int $id): bool
    {
        $sale = self::get($id);

        if (!$sale)
        {
            return false;
        }

        return (bool) $sale->delete();
    }

    /**
     * Get total commission by seller.
     *
     * @param int $seller_id
     * @return float
     */
    public static function getCommissionBySellerId(int $seller_id): float
    {
        return (float) Model::where(Model::SELLER_ID, $seller_id)->sum(Model::COMMISSION);
    }
}
