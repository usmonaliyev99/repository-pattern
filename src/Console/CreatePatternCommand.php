<?php

namespace Usmonaliyev\RepositoryPattern\Console;

use Illuminate\Console\Command;

class CreatePatternCommand extends Command
{
    protected $signature = "create:pattern {name}";

    protected $description = "Create interface and repository files.";

    public function handle()
    {
        $name = $this->argument("name");

        $this->createInterface($name);
        $this->createRepository($name);
        $this->registerPattern($name);

        $this->error("🔄 Please restart your app.");
    }

    public function checkPath()
    {
        if (!file_exists(app_path("Repositories"))) {
            mkdir(app_path("Repositories"));
            $this->info("✅ App/Repositories folder is created.");
        }
        if (!file_exists(app_path("Interfaces"))) {
            mkdir(app_path("Interfaces"));
            $this->info("✅ App/Interfaces folder is created.");
        }
    }

    public function createInterface(string $name)
    {
        $name .= "Interface";
        $interfaceTemplate = $this->getStub("Interface");

        $interfaceTemplate = str_replace("{{NAME_INTERFACE}}", $name, $interfaceTemplate);

        file_put_contents(app_path("Interfaces/$name.php"), $interfaceTemplate);

        $this->info("✅ App/Interface/$name.php is created!");
    }

    public function createRepository(string $name)
    {
        $repositoryTemplate = $this->getStub("Repository");

        $repositoryTemplate = str_replace([
            "{{NAME_REPOSITORY}}",
            "{{NAME_INTERFACE}}",
        ], [
            $name . "Repository",
            $name . "Interface",
        ], $repositoryTemplate);

        file_put_contents(app_path("Repositories/" . $name . "Repository.php"), $repositoryTemplate);

        $this->info("✅ App/Repositories/" . $name . "Repository.php is created!");
    }

    public function registerPattern(string $name)
    {
        $path = base_path("app/Providers/AppServiceProvider.php");
        $appServiceProvider = file_get_contents($path);

        $use = "namespace App\Providers;\n\nuse App\Interfaces\\" . $name . "Interface;\nuse App\Repositories\\" . $name . "Repository;";

        $appServiceProvider = str_replace("namespace App\Providers;\n", $use, $appServiceProvider);

        $register = 'public function boot()'
            . chr(10)
            . '    {' . chr(10)
            . '        $this->app->singleton(' . $name . 'Interface::class, ' . $name . 'Repository::class);';

        $appServiceProvider = str_replace('public function boot()' . chr(10) . '    {', $register, $appServiceProvider);

        file_put_contents($path, $appServiceProvider);

        $this->info("✅ App/Providers/AppServiceProvider.php is changed!");
    }

    public function getStub(string $stubName)
    {
        return file_get_contents(__DIR__ . "/stubs/$stubName.stub");
    }
}
