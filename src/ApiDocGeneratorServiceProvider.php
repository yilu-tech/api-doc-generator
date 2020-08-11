<?php


namespace YiluTech\ApiDocGenerator;


use Illuminate\Support\ServiceProvider;
use YiluTech\ApiDocGenerator\Commands\ApiDocGenerateCommand;

class ApiDocGeneratorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/swagger.php' => config_path('swagger.php'),
        ], ['config', 'api-doc-config']);

        if ($this->app->runningInConsole()) {
            $this->commands([
                ApiDocGenerateCommand::class
            ]);
        }
    }
}