<?php

namespace Laradic\Idea\Metadata\Tests;

abstract class TestCase extends \Laradic\Testing\Laravel\AbstractTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function getServiceProviderClass()
    {
        return \Laradic\Idea\Metadata\MetadataServiceProvider::class;
    }

   /**
    * {@inheritdoc}
    */
    protected function getPackageRootPath()
    {
        return __DIR__ . '/..';
    }
}
