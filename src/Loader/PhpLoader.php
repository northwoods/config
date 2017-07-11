<?php

namespace Northwoods\Config\Loader;

class PhpLoader implements LoaderInterface
{
    public static function isSupported()
    {
        return true;
    }

    public function load($path)
    {
        if (is_file("$path.php")) {
            return require "$path.php";
        } else {
            return [];
        }
    }
}
