<?php

namespace Northwoods\Config;

use PHPUnit\Framework\TestCase;

class FactoryTest extends TestCase
{
    /**
     * @var ConfigFactory
     */
    private $factory;

    public function setUp()
    {
        $this->factory = new ConfigFactory();
    }

    public function testDirectory()
    {
        $config = ConfigFactory::make([
            'directory' => __DIR__ . '/../examples',
        ]);

        // it implements the configuration interfaces
        $this->assertInstanceOf(ConfigInterface::class, $config);
        $this->assertInstanceOf(ConfigDirectory::class, $config);

        // it can fetch existing values
        $this->assertSame('America/New_York', $config->get('app.timezone'));
        $this->assertSame('my_password', $config->get('database.connections.default.password'));

        // it returns null for values that do not exist
        $this->assertNull($config->get('custom.key.option'));

        // it can set custom values
        $this->assertNull($config->set('custom.key.option', true));
        $this->assertTrue($config->get('custom.key.option'));
    }

    public function testEnvironment()
    {
        $config = ConfigFactory::make([
            'directory' => __DIR__ . '/../examples',
            'environment' => 'dev',
        ]);

        // it implements the configuration interfaces
        $this->assertInstanceOf(ConfigInterface::class, $config);
        $this->assertInstanceOf(ConfigCollection::class, $config);

        // it can fetch existing values
        $this->assertSame('Europe/Berlin', $config->get('app.timezone'));

        // it returns null for values that do not exist
        $this->assertNull($config->get('custom.key.option'));

        // it can set custom values
        $this->assertNull($config->set('custom.key.option', true));
        $this->assertTrue($config->get('custom.key.option'));

        // new environments can be created
        $config = ConfigFactory::make([
            'directory' => __DIR__ . '/../examples',
            'environment' => 'prod',
        ]);

        // it can fetch existing values
        $this->assertSame('America/New_York', $config->get('app.timezone'));

        // it will merge base config + prod config
        $this->assertSame([
            'default' => [
                'driver' => 'pdo_mysql',
                'host' => '127.0.0.1',
                'dbname' => 'my_database',
                'user' => 'my_user',
                'password' => 'production-password',
            ]
        ], $config->get('database.connections'));
    }

    public function testYamlDirectory()
    {
        $config = ConfigFactory::make([
            'directory' => __DIR__ . '/../examples',
            'environment' => 'dev',
            'type' => 'yaml',
        ]);

        // it implements the configuration interfaces
        $this->assertInstanceOf(ConfigInterface::class, $config);
        $this->assertInstanceOf(ConfigCollection::class, $config);

        // it can fetch existing values
        $this->assertSame(['shadowhand'], $config->get('users.admins'));
        $this->assertSame(['ada'], $config->get('users.developers'));

        // it returns null for values that do not exist
        $this->assertNull($config->get('custom.key.option'));

        // it can set custom values
        $this->assertNull($config->set('custom.key.option', true));
        $this->assertTrue($config->get('custom.key.option'));

        // new environments can be created
        $config = ConfigFactory::make([
            'directory' => __DIR__ . '/../examples',
            'environment' => 'prod',
            'type' => 'yaml',
        ]);

        // it can fetch existing values
        $this->assertSame(['shadowhand'], $config->get('users.admins'));

        // it returns null for values that do not exist
        $this->assertNull($config->get('users.developers'));
    }
}
