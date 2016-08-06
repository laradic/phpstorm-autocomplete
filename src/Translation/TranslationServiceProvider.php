<?php

namespace Laradic\Phpstorm\Autocomplete\Translation;


/**
 * Class TranslatorServiceProvider
 *
 * @package App\Translator
 * @property-read \Illuminate\Contracts\Foundation\Application $app
 *
 */
class TranslationServiceProvider extends \Illuminate\Translation\TranslationServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerLoader();

        $this->app->singleton('translator', function ($app) {
            $loader = $app[ 'translation.loader' ];

            // When registering the translator component, we'll need to set the default
            // locale as well as the fallback locale. So, we'll grab the application
            // configuration so we can easily get both of these values from there.
            $locale = $app[ 'config' ][ 'app.locale' ];

            $trans = new Translator($loader, $locale, $app[ 'files' ]);

            $trans->setFallback($app[ 'config' ][ 'app.fallback_locale' ]);

            return $trans;
        });
    }

    /**
     * Register the translation line loader.
     *
     * @return void
     */
    protected function registerLoader()
    {
        $this->app->singleton('translation.loader', function ($app) {
            return new FileLoader($app[ 'files' ], $app[ 'path.lang' ]);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [ 'translator', 'translation.loader' ];
    }
}