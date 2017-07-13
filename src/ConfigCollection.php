<?php

namespace Northwoods\Config;

class ConfigCollection implements ConfigInterface
{
    /**
     * @var ConfigInterface[]
     */
    private $configs;

    public function __construct(ConfigInterface ...$configs)
    {
        $this->configs = $configs;
    }

    public function get($dotPath, $default = null)
    {
        foreach ($this->configs as $config) {
            $value = $config->get($dotPath, $default);
            if ($value !== $default) {
                return $value;
            }
        }

        return $default;
    }

    public function set($dotPath, $value)
    {
        $this->configs[0]->set($dotPath, $value);
    }
}
