<?php

namespace aliamini78\ModuleBuilder\Commands;

use App\Traits\FilesList;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeModule extends Command
{

    use FilesList;

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
    protected $description = 'Command for make module directory';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $moduleType = ucfirst($this->choice("what is your module type ? ", ["Api", "Web"], "api"));
        $moduleName = ucfirst($this->ask("what is your module name ? "));


        $this->makeDirectories($moduleType, $moduleName);

        $this->comment("$moduleName module created in $moduleType directory!!");
    }


    public function makeDirectories(string $moduleType, string $moduleName): void
    {
        foreach ($this->files($moduleName, $moduleType) as $file) {
            File::makeDirectory($file["directory"], 0777, true, true);

            if (isset($file['content']))
                File::put($file["directory"] . $file['name'], $file['content']);
        }
    }




}
