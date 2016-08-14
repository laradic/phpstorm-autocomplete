<?php
/**
 * Created by IntelliJ IDEA.
 * User: radic
 * Date: 8/6/16
 * Time: 10:11 PM
 */

namespace Laradic\Idea\Metadata\Translation;


interface LoaderInterface extends \Illuminate\Translation\LoaderInterface
{
    /**
     * @return array
     */
    public function getHints();

    /** @return string */
    public function getPath();
}
