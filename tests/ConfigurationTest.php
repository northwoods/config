<?php

namespace Northwoods\Config\Tests;

use Dotenv\Dotenv;
use Northwoods\Config\Collection;
use PHPUnit_Framework_TestCase;
use Northwoods\Config\Configuration;
use Northwoods\Config\Factory;
use Northwoods\Config\Path\PathCollection;

class ConfigurationTest extends PHPUnit_Framework_TestCase
{
    public function testArray()
    {
        $configuration = new Configuration([
            'path' =>  __DIR__ . "/__files",
            'environment' => 'production',
            'dotenv' => __DIR__ . "/__files"
        ]);

        $this->assertInstanceOf(PathCollection::class, $configuration->getPaths());
        $this->assertCount(1, $configuration->getPaths());
        $this->assertEquals('production', $configuration->getEnvironment());
        $this->assertInstanceOf(Dotenv::class, $configuration->getDotenv());
    }

    public function testInstance()
    {
        $configuration = new Configuration(new Configuration([
            'path' =>  __DIR__ . "/__files",
            'environment' => 'production',
            'dotenv' => __DIR__ . "/__files"
        ]));

        $this->assertInstanceOf(PathCollection::class, $configuration->getPaths());
        $this->assertCount(1, $configuration->getPaths());
        $this->assertEquals('production', $configuration->getEnvironment());
        $this->assertInstanceOf(Dotenv::class, $configuration->getDotenv());
    }
}
