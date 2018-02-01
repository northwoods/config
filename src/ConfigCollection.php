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

    /**
     * @param string $dotPath
     * @param mixed  $default
     *
     * @return mixed
     */
    public function get($dotPath, $default = null)
    {
        $found = null;

        foreach (array_reverse($this->configs) as $config) {

            /** @var ConfigInterface $config */

            $value = $config->get($dotPath, null);

            if ($value === null) {
                continue;
            }

            if (is_array($found) && is_array($value)) {
                $found = array_replace_recursive($found, $value);
            } else {
                $found = $value;
            }
        }

        return $found ?? $default;
    }

    public function set($dotPath, $value)
    {
        $this->configs[0]->set($dotPath, $value);
    }
}
