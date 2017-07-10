<?php

namespace Northwoods\Config\Loader;

interface LoaderInterface
{
    /**
     * @return bool
     */
    public static function isSupported();

    /**
     * @param string $path
     * @return array
     */
    public function load($path);
}
