<?php
declare(strict_types=1);

namespace Northwoods\Config;

/**
 * @param mixed $default
 * @return mixed
 */
function array_path(array $config, string $dotPath, $default = null)
{
    // Working from the first key, descend into the array until nothing is found
    return array_reduce(
        explode('.', $dotPath),
        function ($config, $key) use ($default) {
            return isset($config[$key]) ? $config[$key] : $default;
        },
        $config
    );
}

/**
 * @param mixed $value
 */
function array_path_set(array $config, string $dotPath, $value): array
{
    // Work backward from the last key, wrapping each key in an array
    $replace = array_reduce(
        array_reverse(explode('.', $dotPath)),
        function ($value, $key) {
            return [$key => $value];
        },
        $value
    );

    // Overwrite the array with the replacement
    return array_replace_recursive($config, $replace);
}
