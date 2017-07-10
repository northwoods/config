<?php

namespace Northwoods\Config\Loader;

use Eloquent\Phony\Phpunit\Phony;
use PHPUnit\Framework\TestCase;

class FactoryTest extends TestCase
{
    /**
     * @var LoaderFactory
     */
    private $factory;

    public function setUp()
    {
        $this->factory = new LoaderFactory();
    }

    public function testTypes()
    {
        $loader = $this->factory->forType('php');

        $this->assertInstanceOf(LoaderInterface::class, $loader);
        $this->assertInstanceOf(PhpLoader::class, $loader);
        $this->assertTrue($loader::isSupported());

        $loader = $this->factory->forType('yaml');

        $this->assertInstanceOf(LoaderInterface::class, $loader);
        $this->assertInstanceOf(YamlLoader::class, $loader);
        $this->assertTrue($loader::isSupported());
    }

    public function testPhpLoader()
    {
        $loader = $this->factory->forType('php');

        $config = $loader->load(__DIR__ . '/../../examples/app');
        $this->assertArrayHasKey('timezone', $config);

        $config = $loader->load(__DIR__ . '/failure/fail');
        $this->assertSame([], $config);
    }

    public function testYamlLoader()
    {
        $loader = $this->factory->forType('yaml');

        $config = $loader->load(__DIR__ . '/../../examples/users');
        $this->assertArrayHasKey('admins', $config);

        $config = $loader->load(__DIR__ . '/failure/fail');
        $this->assertSame([], $config);
    }

    public function testInvalidLoader()
    {
        $factory = new LoaderFactory([
            'test' => \stdclass::class,
        ]);

        $this->expectException(LoaderException::class);
        $this->expectExceptionCode(LoaderException::INVALID_LOADER);

        $loader = $factory->forType('test');
    }

    public function testUnsupportedLoader()
    {
        $loader = Phony::mock(LoaderInterface::class);
        $loader = Phony::onStatic($loader);
        $loader->isSupported->returns(false);

        $factory = new LoaderFactory([
            'test' => $loader->className(),
        ]);

        $this->expectException(LoaderException::class);
        $this->expectExceptionCode(LoaderException::UNSUPPORTED_LOADER);

        $loader = $factory->forType('test');
    }
}
