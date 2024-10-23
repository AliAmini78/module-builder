<?php

namespace aliamini78\ModuleBuilder\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for making module directory';

    /**
     * Execute the console command.
     */
    public function handle() : void
    {
        $moduleType = ucfirst($this->choice("What is your module type?", ["Api", "Web"], "Api"));
        $moduleName = ucfirst($this->ask("What is your module name?"));

        $this->makeDirectories($moduleType, $moduleName);
        $this->comment("$moduleName module created in $moduleType directory!!");
    }

    public function makeDirectories(string $moduleType, string $moduleName) : void
    {
        $directories = match ($moduleType){
            "Api" => $this->apiDirectories,
            "Web" => $this->webDirectories,
        };

        foreach ($directories as $directory){
            $path = base_path("modules" . DIRECTORY_SEPARATOR . $moduleType . DIRECTORY_SEPARATOR . $moduleName . DIRECTORY_SEPARATOR . $directory);
            File::makeDirectory($path, 0777, true, true);
        }
    }

    protected array $apiDirectories = [
        "Database" . DIRECTORY_SEPARATOR . "Factories",
        "Database" . DIRECTORY_SEPARATOR . "Seeders",
        "Database" . DIRECTORY_SEPARATOR . "Migrations",
        "Database" . DIRECTORY_SEPARATOR . "Repositories" . DIRECTORY_SEPARATOR . "Contracts",
        "Database" . DIRECTORY_SEPARATOR . "Repositories" . DIRECTORY_SEPARATOR . "Repos",
        "Http" . DIRECTORY_SEPARATOR . "Controllers",
        "Http" . DIRECTORY_SEPARATOR . "Requests",
        "Http" . DIRECTORY_SEPARATOR . "Resources",
        "Models",
        "Providers",
        "Routes"
    ];

    protected array $webDirectories = [
        "Database" . DIRECTORY_SEPARATOR . "Factories",
        "Database" . DIRECTORY_SEPARATOR . "Seeders",
        "Database" . DIRECTORY_SEPARATOR . "Migrations",
        "Database" . DIRECTORY_SEPARATOR . "Repositories" . DIRECTORY_SEPARATOR . "Contracts",
        "Database" . DIRECTORY_SEPARATOR . "Repositories" . DIRECTORY_SEPARATOR . "Repos",
        "Http" . DIRECTORY_SEPARATOR . "Controllers",
        "Http" . DIRECTORY_SEPARATOR . "Requests",
        "Models",
        "Resources" . DIRECTORY_SEPARATOR . "Views",
        "Providers",
        "Routes"
    ];
}
