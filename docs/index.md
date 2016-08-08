<!--
title: IDEA Meta
subtitle: Laravel PHPStorm & IDEA Meta generator
-->
Laravel PHPStorm & IDEA Meta generator
======================================

<!--[![GitHub Version](https://img.shields.io/github/tag/laradic/idea-meta.svg?style=flat-square&label=version)](http://badge.fury.io/gh/laradic%2Fidea-meta)-->
[![Total Downloads](https://img.shields.io/packagist/dt/laradic/idea-meta.svg?style=flat-square)](https://packagist.org/packages/laradic/idea-meta)
[![Documentation](https://img.shields.io/badge/goto-documentation-orange.svg?style=flat-square)](https://docs.laradic.nl/laradic-idea-meta)
[![Source](http://img.shields.io/badge/source-laradic--idea--meta-blue.svg?style=flat-square)](https://bitbucket.org/laradicpackages/laradic-idea-meta)
[![License](http://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://tldrlegal.com/license/mit-license)


`laradic/idea-meta` is a package for the Laravel 5 framework.

The package follows the FIG standards PSR-1, PSR-2, and PSR-4 to ensure a high level of interoperability between shared PHP code.

Introduction
------------
Generates `.phpstorm.meta.php`,like [barryvdh/laravel-ide-helper](#) but allows developers to easily add new their own generators.
Currently generates for Laravel 5:
- Application bindings
- Config
- Routes

Quick Installation
------------------
Begin by installing the package through Composer.

```bash
composer require laradic/idea-meta
```

Add the service provider
```php
Laradic\IdeaMeta\IdeaMetaServiceProvider::class
```

Generate the meta file
```sh
php artisan idea-meta
```

Profit!

Override or add generators
--------------------------

All `Meta` generators should extend the `Laradic\IdeaMeta\Metas\BaseMeta` abstract class.
`Meta` generators can then be added to the `MetaRepository` by for example, using the binding: `app('idea-meta')->add(App\MyCustomMeta::class)`.
 
Here's a quick example:

```php
class ConfigMeta extends BaseMeta
{
    protected $methods = [
        'config(\'\')',
        '\\Config::get(\'\')',
        'new \Illuminate\Contracts\Config\Repository',
        '\Illuminate\Contracts\Config\Repository::get(\'\')'
    ];

    public function getData()
    {
        return array_dot($this->app['config']->all());
    }
}
```

```php
class ConfigMetaServiceProvider extends ServiceProvider {
    public function boot(){
        $this->app['idea-meta']->add(ConfigMeta::class);
    }
}
```

And thats it! You now have code-completion for all your `config` commands.

### Some other examples

##### Routes

```php
class RoutesMeta extends BaseMeta
{
    protected $methods = [
        'route(\'\')',
        '\Illuminate\Routing\RouteCollection::getByName(\'\')',
        '\\URL::route(\'\')',
        'new \Illuminate\Contracts\Routing\UrlGenerator',
        '\Illuminate\Contracts\Routing\UrlGenerator::route(\'\')',
    ];

    public function getData()
    {
        $routes = [ ];
        /** @var \Illuminate\Routing\Route[] */
        $_routes = $this->app[ 'router' ]->getRoutes()->getRoutes();
        foreach ($_routes as $route) {
            $routes[ $route->getName() ] = false; //$route->getUri();
        }
        return $routes;
    }
}
```

##### Codex

```php
class CodexMeta extends BaseMeta
{
    protected $methods = [
        'new \Codex\Core\Codex',
        'codex(\'\')',
    ];

    public function getData()
    {
        return app('Codex\Core\Contracts\Codex')->getExtenableProperty('extensions');
    }

    public static function canRun()
    {
        return class_exists('Codex\Core\Contracts\Codex', false);
    }
}
```

##### Bitbucket

```php
class BitbucketMeta extends BaseMeta
{
    protected $template = <<<'EOF'
@foreach($methods as $method)
    {!! $method !!} => [
        '' == '@',
        @foreach($data as $k => $v)
            '{!! $k !!}' instanceof {!! \Laradic\Support\Str::ensureLeft($v, '\\') !!},
        @endforeach
    ],
@endforeach
EOF;

    protected $methods = [
        'new \Bitbucket\API\Api',
        '\Bitbucket\API\Api::api(\'\')',
    ];


    public function getData()
    {
        $classes = [];
        $apiClasses = [ 'GroupPrivileges', 'Groups',  'Invitations', 'Privileges', 'Repositories', 'Teams', 'User', 'Users' ];
        $apiDir = base_path(Path::join('vendor', 'gentle', 'bitbucket-api', 'lib', 'Bitbucket', 'API'));
        foreach (['Repositories', 'User', 'Users', 'Groups'] as $dir) {
            $files = array_merge(
                glob(Path::join($apiDir, $dir, '*.php')),
                glob(Path::join($apiDir, $dir, '*/*.php'))
            );
            foreach ($files as $filePath) {
                $ext = Path::getExtension($filePath);
                $rel = Path::makeRelative($filePath, $apiDir);
                $res = Str::removeRight($rel, '.' . $ext);
                $apiClasses[] = Str::replace($res, '/', '\\');
            }
        }



        #['BranchRestrictions', 'Changesets', 'Commits', 'Deploykeys']
        foreach ($apiClasses as $apiClass) {
            $classes[$apiClass] = 'Bitbucket\\API\\' . $apiClass;
        }
        return $classes;
    }

    public static function canRun()
    {
        return class_exists('Bitbucket\API\Api', false);
    }
}
```
