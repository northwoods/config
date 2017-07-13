<?php

namespace Northwoods\Config\Loader;

class LoaderFactory
{
    /**
     * @var array
     */
    private $loaders = [
        'php' => PhpLoader::class,
        'yaml' => YamlLoader::class,
    ];

    /**
     * @var LoaderInterface[]
     */
    private $instances = [];

    /**
     * @param array $loaders
     */
    public function __construct(array $loaders = [])
    {
        $this->loaders = array_replace($this->loaders, $loaders);
    }

    /**
     * @param string $extension
     * @return LoaderInterface
     */
    public function forType($extension)
    {
        if (empty($this->instances[$extension])) {
            $this->instances[$extension] = $this->make($this->loaders[$extension]);
        }

        return $this->instances[$extension];
    }

    /**
     * @param string $loader
     * @return LoaderInterface
     * @throws LoaderException
     *  If the requested loader cannot be created.
     */
    private function make($loader)
    {
        if (!is_a($loader, LoaderInterface::class, true)) {
            throw LoaderException::invalidLoader($loader);
        }

        if (!call_user_func([$loader, 'isSupported'])) {
            throw LoaderException::unsupportedLoader($loader);
        }

        return new $loader();
    }
}
