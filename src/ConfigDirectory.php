<?php
declare(strict_types=1);

namespace Northwoods\Config;

use Northwoods\Config\Loader\LoaderInterface;

class ConfigDirectory implements ConfigInterface
{
    /** @var string */
    private $path;

    /** @var LoaderInterface */
    private $loader;

    /** @var array */
    private $config = [];

    public function __construct($path, LoaderInterface $loader)
    {
        $this->path = $path;
        $this->loader = $loader;
    }

    public function get(string $dotPath, $default = null)
    {
        list($name) = explode('.', $dotPath, 2);

        if (!isset($this->config[$name])) {
            $this->config[$name] = $this->loader->load("{$this->path}/$name");
        }

        return array_path($this->config, $dotPath, $default);
    }

    public function set(string $dotPath, $value)
    {
        $this->config = array_path_set($this->config, $dotPath, $value);
    }
}
