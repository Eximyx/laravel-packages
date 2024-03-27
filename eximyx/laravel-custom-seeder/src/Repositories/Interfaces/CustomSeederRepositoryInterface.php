<?php

namespace Eximyx\LaravelCustomSeeder\Repositories\Interfaces;
interface CustomSeederRepositoryInterface
{
    /**
     * @return mixed
     */
    public function getRan();

    /**
     * @param array $data
     * @return bool|void
     */
    public function create(array $data);

}
