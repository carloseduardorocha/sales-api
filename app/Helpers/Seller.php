<?php

namespace App\Helpers;

use App\Models\Seller as Model;
use Illuminate\Database\Eloquent\Collection;

class Seller
{
    /**
     * Get all sellers.
     *
     * @return Collection<int,Model>
     */
    public static function all(): Collection
    {
        return Model::all();
    }

    /**
     * Get a seller by their ID.
     *
     * @param int $id
     * @return Model|null
     */
    public static function get(int $id): ?Model
    {
        return Model::find($id);
    }

    /**
     * Create a new seller.
     *
     * @param string $name
     * @param string $email
     *
     * @return Model
     */
    public static function create(string $name, string $email): Model
    {
        return Model::create([
            Model::NAME  => $name,
            Model::EMAIL => $email,
        ]);
    }

    /**
     * Update a seller by their ID.
     *
     * @param int $id
     * @param string $name
     * @param string $email
     *
     * @return bool
     */
    public static function update(int $id, string $name, string $email): bool
    {
        $seller = self::get($id);

        if (!$seller)
        {
            return false;
        }

        $seller->name = $name;

        if ($seller->email !== $email)
        {
            $seller->email = $email;
        }

        return $seller->save();
    }

    /**
     * Delete a seller by their ID.
     *
     * @param int $id
     * @return bool
     */
    public static function delete(int $id): bool
    {
        $seller = self::get($id);

        if (!$seller)
        {
            return false;
        }

        return (bool) $seller->delete();
    }
}
