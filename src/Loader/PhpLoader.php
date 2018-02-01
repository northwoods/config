<?php
declare(strict_types=1);

namespace Northwoods\Config\Loader;

class PhpLoader implements LoaderInterface
{
    public static function isSupported(): bool
    {
        return true;
    }

    public function load(string $path): array
    {
        if (is_file("$path.php")) {
            return require "$path.php";
        }

        return [];
    }
}
