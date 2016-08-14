<?php
/**
 * Part of the Laradic PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Laradic\Idea\Metadata\Commands;

use Illuminate\Console\Command;
use Laradic\Idea\Metadata\Seeder;

class MetaCommand extends Command
{


    protected $signature = 'phpstorm:meta
                                     {--list : Lists all meta}
                                     {--exclude : Excludes meta}';

    protected $description = 'Generates a .phpstorm.meta.php file with the configured metas';

    public function handle()
    {
        app()->singleton('seeder', Seeder::class);
        app('idea-meta')->create();
    }
}
