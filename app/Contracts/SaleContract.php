<?php

namespace App\Contracts;

interface SaleContract
{
    /**
     * List all sales.
     *
     * @return array<mixed>
     */
    public function list(): array;

    /**
     * Get a sale by its ID.
     *
     * @param int $id
     * @return array<mixed>
     */
    public function get(int $id): array;

    /**
     * Create a new sale.
     *
     * @param int $seller_id
     * @param float $amount
     * @param string $sale_date
     *
     * @return array<mixed>
     */
    public function create(int $seller_id, float $amount, string $sale_date): array;

    /**
     * Update a sale by its ID.
     *
     * @param int $id
     * @param int $seller_id
     * @param float $amount
     * @param string $sale_date
     *
     * @return bool
     */
    public function update(int $id, int $seller_id, float $amount, string $sale_date): bool;

    /**
     * Delete a sale by its ID.
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void;

    /**
     * List all sales by a specific seller.
     *
     * @param int $seller_id
     * @return array<mixed>
     */
    public function getAllSalesBySeller(int $seller_id): array;

    /**
     * Get the total commission for a specific seller.
     *
     * @param int $seller_id
     * @return float
     */
    public function getCommissionBySellerId(int $seller_id): float;
}
