<?php
/**
 * Part of the Laradic PHP packages.
 *
 * MIT License and copyright information bundled with this package in the LICENSE file
 */
namespace Laradic\Idea\Metadata\Metas;

/**
 * This is the ConfigMeta.
 *
 * @package        Laradic
 * @author         Laradic Dev Team
 * @copyright      Copyright (c) 2015, Laradic
 * @license        https://tldrlegal.com/license/mit-license MIT License
 */
class RoutesMeta extends BaseMeta
{
    protected $methods = [
        '\\route(\'\')',
        '\\Illuminate\\Routing\\RouteCollection::getByName(\'\')',
        '\\URL::route(\'\')',
        'new \\Illuminate\\Contracts\\Routing\\UrlGenerator',
        '\\Illuminate\\Contracts\\Routing\\UrlGenerator::route(\'\')',
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
