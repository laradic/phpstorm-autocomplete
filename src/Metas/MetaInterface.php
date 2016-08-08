<?php
/**
 * Part of the Laradic PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Laradic\Phpstorm\Autocomplete\Metas;

interface MetaInterface
{

    public function getData();
    public function getMethods();
    public function getTemplate();
    public static function canRun();
}
