<?php

namespace aliamini78\ModuleBuilder\Traits;

trait FilesList
{
    use FileContent;
    protected function files(string $moduleName, string $moduleType): array
    {
        $array =  [
            [
                "directory" => base_path() . "\\modules\\$moduleType\\$moduleName\\Database\\Factories",
                "name" =>  "\\$moduleName"."Factory.php",
                "content" => $this->factoryContent($moduleName, $moduleType),
            ],
            [
                "directory" =>  base_path() . "\\modules\\$moduleType\\$moduleName\\Database\\Seeders",
                "name" =>  "\\$moduleName"."Seeder.php",
                "content" => $this->seederContent($moduleName, $moduleType),
            ],
            [
                "directory" => base_path() . "\\modules\\$moduleType\\$moduleName\\Database\\Migrations",
                "name" =>  "\\".date('Y_m_d_His') ."_create_" . strtolower($moduleName)."s_table.php",
                "content" => $this->migrationContent($moduleName),
            ],
            [
                "directory" => base_path() . "\\modules\\$moduleType\\$moduleName\\Database\\Repositories\\Contracts",
                "name" =>  "\\{$moduleName}RepositoryInterface.php",
                "content" => $this->repositoryInterfaceContent($moduleName , $moduleType),
            ],
            [
                "directory" => base_path() . "\\modules\\$moduleType\\$moduleName\\Database\\Repositories\\Repos",
                "name" =>  "\\{$moduleName}Repository.php",
                "content" => $this->repositoryContent($moduleName , $moduleType),
            ],
            [
                "directory" => base_path() . "\\modules\\$moduleType\\$moduleName\\Http\\Controllers",
                "name" =>  "\\{$moduleName}Controller.php",
                "content" => $this->controllerContent($moduleName , $moduleType),
            ],
            [
                "directory" => base_path() . "\\modules\\$moduleType\\$moduleName\\Http\\Requests",
                "name" =>  "\\{$moduleName}Controller.php",
            ],
            [
                "directory" => base_path() . "\\modules\\$moduleType\\$moduleName\\Models",
                "name" =>  "\\{$moduleName}.php",
                "content" => $this->modelContent($moduleName , $moduleType),
            ],
            [
                "directory" => base_path() . "\\modules\\$moduleType\\$moduleName\\Providers",
                "name" =>  "\\{$moduleName}ServiceProvider.php",
                "content" => $this->serviceProviderContent($moduleName , $moduleType),
            ],
            [
                "directory" => base_path() . "\\modules\\$moduleType\\$moduleName\\Providers",
                "name" =>  "\\{$moduleName}RepositoryPatternServiceProvider.php",
                "content" => $this->repositoryPatternServiceProviderContent($moduleName , $moduleType),
            ],
            [
                "directory" => base_path() . "\\modules\\$moduleType\\$moduleName\\Routes",
                "name" => match ($moduleType){
                    "Web" => "\\web_routes.php",
                    "Api" => "\\api_routes.php",
                },
                "content" => "<?php",
            ],
        ];

        $array[] = match ($moduleType){
            "Web" => [
                "directory" => base_path() . "\\modules\\$moduleType\\$moduleName\\Resources\\Views",
            ],
            "Api" => [
                "directory" => base_path() . "\\modules\\$moduleType\\$moduleName\\Http\\Resources",
            ],
        };

        return $array;
    }
}
