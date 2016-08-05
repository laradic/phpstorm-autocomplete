<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * MIT License and copyright information bundled with this package in the LICENSE file
 */
namespace Laradic\Phpstorm\Autocomplete\Metas;

use Illuminate\Contracts\Config\Repository;

/**
 * This is the ConfigMeta.
 *
 * @package        Sebwite
 * @author         Sebwite Dev Team
 * @copyright      Copyright (c) 2015, Sebwite
 * @license        https://tldrlegal.com/license/mit-license MIT License
 */
class ConfigMeta extends BaseMeta
{
    protected $methods = [
        '\\config(\'\')',
        '\\Config::get(\'\')',
        'new \\Illuminate\\Contracts\\Config\\Repository',
        '\\Illuminate\\Contracts\\Config\\Repository::get(\'\')'
    ];

    public function getData()
    {
        return array_dot($this->app['config']->all());
    }
}
