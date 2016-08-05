<?php
namespace Laradic\Phpstorm\Autocomplete\Metas;

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

    }
}
