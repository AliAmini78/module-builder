<?php

namespace aliamini78\ModuleBuilder\Traits;

trait FileContent
{


    protected function factoryContent(string $moduleName,string $moduleType): string
    {
        return   "<?php

namespace $moduleType\\$moduleName\Database\Factories;

use Illuminate\\Database\\Eloquent\\Factories\\Factory;
use {$moduleType}\\{$moduleName}\Models\\{$moduleName};

class {$moduleName}Factory extends Factory
{
    protected \$model = {$moduleName}::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Your factory definitions go here
        ];
    }
}
";
    }


    protected function seederContent(string $moduleName,string $moduleType): string
    {
        return   "<?php

namespace $moduleType\\$moduleName\\Database\\Seeders;

use Illuminate\\Database\\Seeder;

class {$moduleName}Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Add seeder logic here
    }
}
";
    }


    protected function migrationContent(string $moduleName): string
    {
        $tableName = strtolower($moduleName) . "s";

    return "<?php

use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('$tableName', function (Blueprint \$table) {
            \$table->id();
            \$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('$tableName');
    }
};
";
    }


    public function repositoryInterfaceContent(string $moduleName, string $moduleType) : string
    {
        return  "<?php

namespace $moduleType\\$moduleName\\Database\\Repositories\\Contracts;

use $moduleType\\Base\\Database\\Repositories\\Contracts\\BaseRepositoryInterface;

interface {$moduleName}RepositoryInterface extends BaseRepositoryInterface
{

}
";
    }


    public function repositoryContent(string $moduleName, string $moduleType) : string
    {
        return   "<?php

namespace $moduleType\\$moduleName\\Database\\Repositories\\Repos;

use $moduleType\\Base\\Database\\Repositories\\Repo\\BaseRepository;
use $moduleType\\$moduleName\\Database\\Repositories\\Contracts\\{$moduleName}RepositoryInterface;
use $moduleType\\$moduleName\\Models\\$moduleName;

class {$moduleName}Repository extends BaseRepository implements {$moduleName}RepositoryInterface
{

    public function __construct($moduleName \$model)
    {
        \$this->model = \$model;
    }
}
";
    }


    public function controllerContent(string $moduleName, string $moduleType) : string
    {
        $repositoryInterface = "{$moduleName}RepositoryInterface";
        $controllerName = "{$moduleName}Controller";
        $repository = lcfirst($moduleName) . 'Repository';

        return"<?php

namespace $moduleType\\$moduleName\\Http\\Controllers;

use $moduleType\\Base\\Http\\Controllers\\ApiController;
use $moduleType\\$moduleName\\Database\\Repositories\\Contracts\\$repositoryInterface;

class $controllerName extends ApiController
{
    private $repositoryInterface \$$repository;

    public function __construct($repositoryInterface \$$repository)
    {
        \$this->$repository = \$$repository;
    }

    public function index()
    {
    }
}
";

    }

    public function modelContent(string $moduleName, string $moduleType) : string
    {
        $modelName = ucfirst($moduleName);
        $factoryName = "{$modelName}Factory";

        return  "<?php

namespace $moduleType\\$moduleName\\Models;

use $moduleType\\$moduleName\\Database\\Factories\\$factoryName;
use Illuminate\\Database\\Eloquent\\Factories\\HasFactory;
use Illuminate\\Database\\Eloquent\\Model;

class $modelName extends Model
{
    use HasFactory;

    protected \$fillable = [
        // Your fillable attributes here
    ];

    protected \$casts = [
        // Your casted attributes here
    ];

    /**
     * @return $factoryName
     */
    protected static function newFactory(): $factoryName
    {
        return $factoryName::new();
    }
}
";

    }

    public function serviceProviderContent(string $moduleName, string $moduleType) : string
    {
        $modulePrefix = "api";
        $moduleAuthMiddleWare = "sanctum";

        if ($moduleType === "Web"){
            $modulePrefix = "web";
            $moduleAuthMiddleWare = "web";
        }
        return"<?php

namespace $moduleType\\$moduleName\\Providers;

use Illuminate\\Support\\Facades\\Route;
use Illuminate\\Support\\ServiceProvider;

class {$moduleName}ServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     */
    public function register(): void
    {
        // for register user repository pattern
        \$this->app->register({$moduleName}RepositoryPatternServiceProvider::class);

        // register migration path
        \$this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        // register route path
        Route::prefix('{$modulePrefix}')
            ->middleware(['{$modulePrefix}', 'auth:{$moduleAuthMiddleWare}'])
            ->group(__DIR__ . '/../Routes/{$modulePrefix}_routes.php');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
";
    }

    public function repositoryPatternServiceProviderContent(string $moduleName, string $moduleType) : string
    {
        return"<?php

namespace $moduleType\\$moduleName\\Providers;

use $moduleType\\$moduleName\\Database\\Repositories\\Contracts\\{$moduleName}RepositoryInterface;
use $moduleType\\$moduleName\\Database\\Repositories\\Repo\\{$moduleName}Repository;
use Illuminate\\Support\\ServiceProvider;

class {$moduleName}RepositoryPatternServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
{
    \$this->app->bind({$moduleName}RepositoryInterface::class, {$moduleName}Repository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
{
    //
}
}
";
    }

}
