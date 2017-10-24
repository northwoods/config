<?php

namespace Northwoods\Config\Decorator;

use Eloquent\Phony\Phpunit\Phony;
use Northwoods\Config\ConfigInterface;
use PHPUnit\Framework\TestCase;

class VariableDecoratorTest extends TestCase
{
    /**
     * @var \Eloquent\Phony\Mock\Handle\InstanceHandle
     */
    private $decorated;

    public function setUp()
    {
        $this->config = Phony::mock(ConfigInterface::class);
        $this->config->get
            ->with('email.directory')->returns('%vendorDir%/emails')
            ->with('users.admins')->returns(['root', '%adminUser%'])
            ->with('users.locked')->returns(true);
    }

    public function testDecorator()
    {
        $config = new VariableDecorator($this->config->get());
        $config->setVariables([
            '%vendorDir%' => __DIR__,
            '%adminUser%' => 'jane',
        ]);

        $this->assertSame(__DIR__ . '/emails', $config->get('email.directory'));
        $this->assertSame(['root', 'jane'], $config->get('users.admins'));
        $this->assertSame(true, $config->get('users.locked'));
        $this->assertNull($config->set('users.locked', true));
    }
}
