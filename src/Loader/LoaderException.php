<?php

namespace Northwoods\Config\Loader;

class LoaderException extends \RuntimeException
{
    const INVALID_LOADER = 1;
    const UNSUPPORTED_LOADER = 2;

    /**
     * @param string $class
     * @return static
     */
    public static function invalidLoader($class)
    {
        return new static("Loader does not implement LoaderIterface: $class", self::INVALID_LOADER);
    }

    /**
     * @param string $class
     * @return static
     */
    public static function unsupportedLoader($class)
    {
        return new static("Loader is missing dependencies: $class", self::UNSUPPORTED_LOADER);
    }
}
