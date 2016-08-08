<?php

namespace Laradic\Phpstorm\Autocomplete;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

/**
 * The main service provider
 *
 * @author        Laradic
 * @copyright     Copyright (c) 2015, Laradic
 * @license       http://mit-license.org MIT
 * @package       Laradic\Phpstorm\Autocomplete
 */
class AutocompleteServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $viewPath = __DIR__ . '/../resources/views';
        $this->loadViewsFrom($viewPath, 'phpstorm-autocomplete');

        $configPath = __DIR__ . '/../config/phpstorm-autocomplete.php';
        if (function_exists('config_path')) {
            $publishPath = config_path('phpstorm-autocomplete.php');
        } else {
            $publishPath = base_path('config/phpstorm-autocomplete.php');
        }
        $this->publishes([ $configPath => $publishPath ], 'config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $configPath = __DIR__ . '/../config/phpstorm-autocomplete.php';
        $this->mergeConfigFrom($configPath, 'phpstorm-autocomplete');

        $this->app->singleton('phpstorm-autocomplete', MetaRepository::class);
        $this->app->alias('phpstorm-autocomplete', MetaRepositoryInterface::class);
        $this->app->alias('phpstorm-autocomplete', 'idea-meta');

        $this->app[ 'command.phpstorm-autocomplete.generate' ] = $this->app->share(function (Application $app) {
            return $app->make(Commands\MetaCommand::class);
        });

        $this->commands('command.phpstorm-autocomplete.generate');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [ 'command.phpstorm-autocomplete.generate', 'phpstorm-autocomplete', 'idea-meta' ];
    }
}
