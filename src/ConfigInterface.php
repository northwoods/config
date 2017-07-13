<?php

namespace Northwoods\Config;

interface ConfigInterface
{
    /**
     * @param string $dotPath
     * @param mixed $default
     * @return mixed
     */
    public function get($dotPath, $default = null);

    /**
     * @param string $dotPath
     * @param mixed $value
     * @return void
     */
    public function set($dotPath, $value);
}
