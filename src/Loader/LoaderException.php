<?php
declare(strict_types=1);

namespace Northwoods\Config\Loader;

class LoaderException extends \RuntimeException
{
    const INVALID_LOADER = 1;
    const UNSUPPORTED_LOADER = 2;

    public static function invalidLoader(string $class): LoaderException
    {
        return new static("Loader does not implement LoaderIterface: $class", self::INVALID_LOADER);
    }

    public static function unsupportedLoader(string $class): LoaderException
    {
        return new static("Loader is missing dependencies: $class", self::UNSUPPORTED_LOADER);
    }
}
