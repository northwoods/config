<?php
declare(strict_types=1);

namespace Northwoods\Config;

use Northwoods\Config\Loader\LoaderFactory;

class ConfigFactory
{
    public static function make(array $options, LoaderFactory $loader = null): ConfigInterface
    {
        $factory = new static($loader);
        $type = array_path($options, 'type', 'php');

        if (!empty($options['environment'])) {
            return $factory->forEnvironment($options['directory'], $options['environment'], $type);
        }

        return $factory->forDirectory($options['directory'], $type);
    }

    /** @var LoaderFactory */
    private $loader;

    public function __construct(LoaderFactory $loader = null)
    {
        $this->loader = $loader ?: new LoaderFactory();
    }

    public function forDirectory(string $directory, string $type = 'php'): ConfigDirectory
    {
        return new ConfigDirectory($directory, $this->loader->forType($type));
    }

    public function forEnvironment(string $directory, string $environment, string $type = 'php'): ConfigCollection
    {
        return new ConfigCollection(
            $this->forDirectory("$directory/$environment", $type),
            $this->forDirectory($directory, $type)
        );
    }
}
