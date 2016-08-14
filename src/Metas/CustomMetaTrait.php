<?php
/**
 * Copyright (c) 2016 Robin Radic.
 *
 * License can be found inside the package and is available at radic.mit-license.org.
 *
 * @author             Robin Radic
 * @copyright          Copyright (c) 2015, Robin Radic. All rights reserved
 * @license            https://radic.mit-license.org The MIT License (MIT)
 */

namespace Laradic\Idea\Metadata\Metas;


trait CustomMetaTrait
{
    protected static $customs = [ ];

    public static function addCustom($binding, $concrete)
    {
        static::$customs[ $binding ] = $concrete;
    }

    public static function hasCustom($binding)
    {
        return array_key_exists($binding, static::$customs);
    }

    public static function removeCustom($binding)
    {
        unset(static::$customs[ $binding ]);
    }

    public static function getCustom($binding = null)
    {
        return $binding ? static::$customs[ $binding ] : static::$customs;
    }
}
