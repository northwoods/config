<?php

namespace Northwoods\Config\Decorator;

use Northwoods\Config\ConfigInterface;

class VariableDecorator implements ConfigInterface
{
    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * @var array [ key => value, ... ]
     */
    private $variables = [];

    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * Define variables to replace
     *
     * @return self
     */
    public function setVariables(array $map)
    {
        $this->variables = $map;
        return $this;
    }

    // ConfigInterface
    public function get($dotPath, $default = null)
    {
        return $this->replaceVariables($this->config->get($dotPath));
    }

    // ConfigInterface
    public function set($dotPath, $value)
    {
        return $this->config->set($dotPath, $value);
    }

    /**
     * @param mixed $value
     * @return mixed
     */
    private function replaceVariables($value)
    {
        if (is_string($value)) {
            return strtr($value, $this->variables);
        }

        if (is_array($value)) {
            return array_map(
                function ($value) {
                    return $this->replaceVariables($value);
                },
                $value
            );
        }

        return $value;
    }
}
