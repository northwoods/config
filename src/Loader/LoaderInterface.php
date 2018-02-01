<?php
declare(strict_types=1);

namespace Northwoods\Config\Loader;

interface LoaderInterface
{
    /**
     * Can this loader be used in the current environment?
     */
    public static function isSupported(): bool;

    /**
     * Load a configuration by path.
     */
    public function load(string $path): array;
}
