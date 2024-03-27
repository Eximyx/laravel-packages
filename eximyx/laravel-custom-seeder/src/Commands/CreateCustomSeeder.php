<?php

namespace Eximyx\LaravelCustomSeeder\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class CreateCustomSeeder extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'create:seeder';

    /**
     * The default name of the console command.
     *
     * @var string
     */
    protected static $defaultName = 'create:seeder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command allows to create a custom Seeder for app';

    /**
     * The type of class which will be created.
     *
     * @var string
     */
    protected $type = "Seeder";

    /**
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\Database\Seeders\CustomSeeders';
    }

    /**
     * @return string
     */
    public function getStub(): string
    {
        return base_path().'/stubs/seeder.stub';
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name): string
    {
        $name = explode("/", str_replace("\\", "/", $name));

        array_shift($name);

        $className = array_pop($name) . ".php";

        $folderName = array_pop($name);

        return  strtolower(implode("/", $name)) . "/" . $folderName . "/".now()->format('Y_m_d_His') ."_" . $className;
    }

}
