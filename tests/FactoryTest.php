<?php

namespace Northwoods\Config\Tests;

use Northwoods\Config\Collection;
use PHPUnit_Framework_TestCase;
use Northwoods\Config\Factory;

class FactoryTest extends PHPUnit_Framework_TestCase
{
    public function testFactory()
    {
        $factory = new Factory();
        /** @var Collection $collection */
        $collection = $factory([]);
        $this->assertInstanceOf(Collection::class, $collection);
    }
}
