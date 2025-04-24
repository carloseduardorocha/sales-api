<?php

namespace App\Services;

use App\Helpers\Seller;
use App\Contracts\SellerContract;
use App\Exceptions\SellerNotFoundException;

class SellerService implements SellerContract
{
    public function list(): array
    {
        return Seller::all()->toArray();
    }

    public function get(int $id): array
    {
        $seller = Seller::get($id)?->toArray();

        if (empty($seller))
        {
            throw new SellerNotFoundException();
        }

        return $seller;
    }

    public function create(string $name, string $email): array
    {
        return Seller::create($name, $email)->toArray();
    }

    public function update(int $id, string $name, string $email): bool
    {
        $seller = Seller::get($id)?->toArray();

        if (empty($seller))
        {
            throw new SellerNotFoundException();
        }

        return Seller::update($id, $name, $email);
    }

    public function delete(int $id): void
    {
        $seller = Seller::get($id)?->toArray();

        if (empty($seller))
        {
            throw new SellerNotFoundException();
        }

        Seller::delete($id);
    }
}
