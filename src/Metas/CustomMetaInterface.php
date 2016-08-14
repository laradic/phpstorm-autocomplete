<?php
/**
 * Copyright (c) 2016 Robin Radic.
 *
 * License can be found inside the package and is available at radic.mit-license.org.
 *
 * @author             Robin Radic
 * @copyright         Copyright (c) 2015, Robin Radic. All rights reserved
 * @license          https://radic.mit-license.org The MIT License (MIT)
 */
namespace Laradic\Idea\Metadata\Metas;

interface CustomMetaInterface
{
    public static function addCustom($binding, $concrete);

    public static function hasCustom($binding);

    public static function removeCustom($binding);

    public static function getCustom($binding = null);
}
