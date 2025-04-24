<?php

namespace App\Contracts;

interface SellerContract
{
    /**
     * List all sellers.
     *
     * @return array<mixed>
     */
    public function list(): array;

    /**
     * Get a seller by their ID.
     *
     * @param int $id
     * @return array<mixed>
     */
    public function get(int $id): array;

    /**
     * Create a new seller.
     *
     * @param string $name
     * @param string $email
     *
     * @return array<mixed>
     */
    public function create(string $name, string $email): array;

    /**
     * Update a seller by their ID.
     *
     * @param int $id
     * @param string $name
     * @param string $email
     *
     * @return bool
     */
    public function update(int $id, string $name, string $email): bool;

    /**
     * Delete a seller by their ID.
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void;
}
