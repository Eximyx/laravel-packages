<?php

namespace Eximyx\LaravelCustomSeeder\Services;
use Eximyx\LaravelCustomSeeder\Repositories\CustomSeederRepository;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;

class CustomSeederService
{

    /**
     * @param Filesystem $files
     * @param CustomSeederRepository $repository
     */
    public function __construct(
        protected Filesystem $files,
        protected CustomSeederRepository $repository,
    ) {}

    /**
     * @return void
     * @throws FileNotFoundException
     */
    public function run(): void
    {
        $files = $this->getSeeders();

        $this->requireFiles(
            $seeder = $this->pendingSeeders(
                $files, $this->repository->getRan()
            )
        );

        foreach ($seeder as $class) {
            try {
                $seed = $this->files->getRequire($class);

                if (is_object($seed)) {
                    $seed->run();

                    $this->repository->create([
                        'title' => $this->files->name($class)
                    ]);
                }
            } catch (\Exception $e) {
                dd($e);
            }
        }
    }

    /**
     * @return array
     */
    protected function getSeeders(): array
    {
        return collect(
            $this->files->glob(
            database_path() ."/seeders/CustomSeeders/*.php"
            )
        )
            ->filter()
            ->values()
            ->keyBy(fn ($path) => $this->files->name($path))
            ->all();
    }

    /**
     * @param array $files
     * @param array $ran
     * @return array
     */
    protected function pendingSeeders(array $files, array $ran): array
    {
        return Collection::make($files)
            ->reject(fn ($file) => in_array($this->files->name($file), $ran))
            ->values()
            ->all();
    }

    /**
     * @param array $files
     * @return void
     * @throws FileNotFoundException
     */
    protected function requireFiles(array $files): void
    {
        foreach ($files as $file) {
            $this->files->requireOnce($file);
        }
    }
}
