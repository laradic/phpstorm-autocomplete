<?php
/**
 * Part of the Laradic PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */
namespace Laradic\Idea\Metadata;

/**
 * This is the MetaRepository.
 *
 * @package        Laradic
 * @author         Laradic Dev Team
 * @copyright      Copyright (c) 2015, Laradic
 * @license        https://tldrlegal.com/license/mit-license MIT License
 */
interface MetaRepositoryInterface
{
    public function add($name, $class);

    public function create($path = null, $viewFile = null);
}
