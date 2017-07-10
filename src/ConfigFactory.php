<?php

namespace Northwoods\Config;

use Northwoods\Config\Loader\LoaderFactory;

class ConfigFactory
{
    /**
     * @return ConfigInterface
     */
    public static function make(array $options, LoaderFactory $loader = null)
    {
        $factory = new static($loader);
        $type = array_path($options, 'type', 'php');

        if (!empty($options['environment'])) {
            return $factory->forEnvironment($options['directory'], $options['environment'], $type);
        }

        return $factory->forDirectory($options['directory'], $type);
    }

    /**
     * @var LoaderFactory
     */
    private $loader;

    public function __construct(LoaderFactory $loader = null)
    {
        $this->loader = $loader ?: new LoaderFactory();
    }

    /**
     * @param string $directory
     * @return ConfigDirectory
     */
    public function forDirectory($directory, $type = 'php')
    {
        return new ConfigDirectory($directory, $this->loader->forType($type));
    }

    /**
     * @param string $directory
     * @param string $environment
     * @return ConfigCollection
     */
    public function forEnvironment($directory, $environment, $type = 'php')
    {
        return new ConfigCollection(
            $this->forDirectory("$directory/$environment", $type),
            $this->forDirectory($directory, $type)
        );
    }
}
