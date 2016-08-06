<?php
namespace Laradic\Phpstorm\Autocomplete\Translation;

use Illuminate\Translation\FileLoader as BaseLoader;

class FileLoader extends BaseLoader implements LoaderInterface
{
    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return array
     */
    public function getHints()
    {
        return $this->hints;
    }

}
