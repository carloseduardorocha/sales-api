<?php

namespace App\Services;

use App\Helpers\Sale;
use App\Contracts\SaleContract;
use App\Exceptions\SaleNotFoundException;

class SaleService implements SaleContract
{
    public function list(): array
    {
        return Sale::all()->toArray();
    }

    public function get(int $id): array
    {
        $sale = Sale::get($id)?->toArray();

        if (empty($sale))
        {
            throw new SaleNotFoundException();
        }

        return $sale;
    }

    public function create(int $seller_id, float $amount, string $sale_date): array
    {
        return Sale::create($seller_id, $amount, $sale_date)->toArray();
    }

    public function update(int $id, int $seller_id, float $amount, string $sale_date): bool
    {
        $sale = Sale::get($id)?->toArray();

        if (empty($sale))
        {
            throw new SaleNotFoundException();
        }

        return Sale::update($id, $seller_id, $amount, $sale_date);
    }

    public function delete(int $id): void
    {
        $sale = Sale::get($id)?->toArray();

        if (empty($sale))
        {
            throw new SaleNotFoundException();
        }

        Sale::delete($id);
    }

    public function getAllSalesBySeller(int $seller_id): array
    {
        return Sale::getBySellerId($seller_id)->toArray();
    }

    public function getCommissionBySellerId(int $seller_id): float
    {
        return Sale::getCommissionBySellerId($seller_id);
    }
}
