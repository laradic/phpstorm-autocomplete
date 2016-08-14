<?php
/**
 * Part of the Laradic PHP packages.
 *
 * MIT License and copyright information bundled with this package in the LICENSE file
 */
namespace Laradic\Idea\Metadata\Metas;

use Illuminate\Contracts\Foundation\Application;
use Laradic\Idea\Metadata\Metas\MetaInterface as MetaContract;

/**
 * This is the ConfigMeta.
 *
 * @package        Laradic
 * @author         Laradic Dev Team
 * @copyright      Copyright (c) 2015, Laradic
 * @license        https://tldrlegal.com/license/mit-license MIT License
 */
abstract class BaseMeta implements MetaContract
{
    protected $template = <<<'EOF'
@foreach($methods as $method)
    {!! $method !!} => [
        '' == '@',
        @foreach($data as $k => $v)
            '{!! $k !!}' instanceof {!! \Laradic\Support\Str::ensureLeft(is_string($v) && class_exists($v, false) ? $v : 'null', '\\') !!},
        @endforeach
    ],
@endforeach
EOF;

    protected $methods = [ ];


    protected $app;

    /**
     * BindingsMeta constructor.
     *
     * @param $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function getMethods()
    {
        return $this->methods;
    }

    public function getTemplate()
    {
        return $this->template;
    }

    public static function canRun()
    {
        return true;
    }
}
