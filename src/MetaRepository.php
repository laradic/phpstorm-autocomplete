<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * MIT License and copyright information bundled with this package in the LICENSE file
 */
namespace Laradic\Phpstorm\Autocomplete;

use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;

/**
 * This is the MetaRepository.
 *
 * @package        Sebwite
 * @author         Sebwite Dev Team
 * @copyright      Copyright (c) 2015, Sebwite
 * @license        https://tldrlegal.com/license/mit-license MIT License
 *
 *
 * @method Metas\BaseMeta[] all()
 * @method Metas\BaseMeta get($key, $default = null)
 */
class MetaRepository extends Collection implements MetaRepositoryInterface
{

    protected $container;

    /**
     * @var \Illuminate\Contracts\View\Factory
     */
    protected $views;

    /**
     * @var \Sebwite\Support\Filesystem
     */
    protected $files;

    protected $generator;

    /**
     * MetaRepository constructor.
     *
     * @param \Illuminate\Contracts\Container\Container $container
     * @param \Illuminate\Contracts\View\Factory        $views
     * @param \Sebwite\Support\Filesystem               $files
     * @param \Sebwite\Support\StubGenerator            $generator
     */
    public function __construct(Container $container, Factory $views, Filesystem $files)
    {
        $this->container = $container;
        $this->views     = $views;
        $this->files     = $files;
        $this->generator = new StubGenerator();

        parent::__construct(config('phpstorm-autocomplete.metas'));
    }

    public function add($name, $class)
    {
        if (!class_exists($class)) {
            throw new FileNotFoundException("Could not find class $class");
        }
        $this->put($name, $class);
    }

    public function create($path = null, $viewFile = null)
    {
        $path     = is_null($path) ? config('phpstorm-autocomplete.output') : $path;
        $viewFile = is_null($viewFile) ? config('phpstorm-autocomplete.view') : $viewFile;

        try {
            $metas = [ ];

            foreach ($this->all() as $name => $class) {
                if ( $this->exists($class) !== true || $class::canRun() === false) {
                    continue;
                }

                $meta    = $this->createMetaClass($class);
                $methods = $meta->getMethods();
                $data    = $meta->getData();
                $metas[] = $this->generator->render($meta->getTemplate(), compact('methods', 'data'));
            }

            $open    = '<?php';
            $content = $this->views->make($viewFile, compact('open', 'metas'))->render();

            $this->files->put($path, $content);
        } catch (\Exception $e) {
            throw $e;
        }
    }


    /** @return Metas\MetaInterface $meta */
    protected function createMetaClass($className)
    {
        return $this->container->make($className);
    }

    protected function exists($class)
    {
        $exists = false;
        try {
            $exists = class_exists($class);
        } catch(\Exception $e){
            return false;
        }
        return $exists;
    }
}
