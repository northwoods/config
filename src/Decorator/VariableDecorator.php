<?php
declare(strict_types=1);

namespace Northwoods\Config\Decorator;

use Northwoods\Config\ConfigInterface;

class VariableDecorator implements ConfigInterface
{
    /** @var ConfigInterface */
    private $config;

    /** @var array */
    private $variables = [];

    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    public function setVariables(array $map): self
    {
        $this->variables = $map;
        return $this;
    }

    public function get(string $dotPath, $default = null)
    {
        return $this->replaceVariables($this->config->get($dotPath));
    }

    public function set(string $dotPath, $value)
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
