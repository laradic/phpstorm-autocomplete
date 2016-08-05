<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */
namespace Laradic\Phpstorm\Autocomplete;

/**
 * This is the MetaRepository.
 *
 * @package        Sebwite
 * @author         Sebwite Dev Team
 * @copyright      Copyright (c) 2015, Sebwite
 * @license        https://tldrlegal.com/license/mit-license MIT License
 */
interface MetaRepositoryInterface
{
    public function add($name, $class);

    public function create($path = null, $viewFile = null);
}
