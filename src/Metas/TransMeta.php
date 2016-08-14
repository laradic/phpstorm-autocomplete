<?php
namespace Laradic\Idea\Metadata\Metas;

use Illuminate\Contracts\Foundation\Application;
use Laradic\Idea\Metadata\Translation\Translator;

class TransMeta extends BaseMeta
{
    protected $methods = [
        'new \\Illuminate\\Translation\\Translator',
        '\\Illuminate\\Translation\\Translator::get(\'\')',
        '\\Illuminate\\Translation\\Translator::has(\'\')',
        '\\Illuminate\\Translation\\Translator::trans(\'\')',
        '\\trans(\'\')',
        '\\Lang::get(\'\')'
    ];

    public function getData()
    {
        return array_dot($this->app->make('translator')->all());
    }

    public static function canRun()
    {
        return app() instanceof Application && app('translator') instanceof Translator;
    }


}
