<?php
declare(strict_types=1);

namespace Northwoods\Config;

interface ConfigInterface
{
    /**
     * Get an item from current configuration.
     *
     * @param mixed $default
     * @return mixed
     */
    public function get(string $dotPath, $default = null);

    /**
     * Set an item in current configuration.
     *
     * @param mixed $value
     * @return void
     */
    public function set(string $dotPath, $value);
}
