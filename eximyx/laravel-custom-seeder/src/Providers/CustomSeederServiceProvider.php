<?php

namespace Eximyx\LaravelCustomSeeder\Providers;

use Eximyx\LaravelCustomSeeder\Commands\CreateCustomSeeder;
use Eximyx\LaravelCustomSeeder\Repositories\CustomSeederRepository;
use Eximyx\LaravelCustomSeeder\Repositories\Interfaces\CustomSeederRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class CustomSeederServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $appPath = base_path();

            $migrationPath = __DIR__ . '/../Migrations/seeder.php';
            $stubPath = __DIR__ . '/../Stubs/Seeder.stub';

            $publishingArr = [
                $stubPath => $appPath . "/stubs" . "/seeder.stub",
                $migrationPath => $appPath . "/database/migrations/2019_12_14_000002_create_seeders_table.php"
            ];

            $this->publishes($publishingArr);

            $this->commands(
                CreateCustomSeeder::class
            );
        }
    }

    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            CustomSeederRepositoryInterface::class,
            CustomSeederRepository::class
        );
    }
}
