<?php
declare(strict_types=1);

namespace Northwoods\Config;

class ConfigCollection implements ConfigInterface
{
    /** @var ConfigInterface[] */
    private $configs;

    public function __construct(ConfigInterface ...$configs)
    {
        $this->configs = $configs;
    }

    public function get(string $dotPath, $default = null)
    {
        return array_reduce(array_reverse($this->configs), $this->reducer($dotPath), $default);
    }

    public function set(string $dotPath, $value)
    {
        $this->configs[0]->set($dotPath, $value);
    }

    private function reducer(string $dotPath): callable
    {
        return static function ($currentValue, ConfigInterface $config) use ($dotPath) {
            $found = $config->get($dotPath, null);

            if ($found === null) {
                return $currentValue;
            }

            if (is_array($currentValue) && is_array($found)) {
                return array_replace_recursive($currentValue, $found);
            }

            return $found;
        };
    }
}
