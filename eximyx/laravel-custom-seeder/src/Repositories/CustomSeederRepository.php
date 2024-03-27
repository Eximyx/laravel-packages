<?php

namespace Eximyx\LaravelCustomSeeder\Repositories;

use Eximyx\LaravelCustomSeeder\Repositories\Interfaces\CustomSeederRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CustomSeederRepository implements CustomSeederRepositoryInterface
{
    /**
     * @return array<string>
     */
    public function getRan(): array
    {
        return DB::table("seeders")
            ->orderBy("created_at")
            ->pluck("title")
            ->all();
    }

    /**
     * @param array $data
     * @return bool
     */
    public function create(array $data): bool
    {
        DB::table("seeders")
            ->insert($data);

        return true;
    }
}
