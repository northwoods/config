<?php

namespace Northwoods\Config;

/**
 * @param array $config
 * @param string $dotPath
 * @param mixed $default
 * @return mixed
 */
function array_path(array $config, $dotPath, $default = null)
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
 * @param array $config
 * @param string $dotPath
 * @param mixed $value
 * @return array
 */
function array_path_set(array $config, $dotPath, $value)
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
