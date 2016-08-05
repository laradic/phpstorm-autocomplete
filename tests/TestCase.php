<?php

namespace Laradic\Phpstorm\Autocomplete\Tests;

abstract class TestCase extends \Laradic\Testing\Laravel\AbstractTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function getServiceProviderClass()
    {
        return \Laradic\Phpstorm\Autocomplete\AutocompleteServiceProvider::class;
    }

   /**
    * {@inheritdoc}
    */
    protected function getPackageRootPath()
    {
        return __DIR__ . '/..';
    }
}
