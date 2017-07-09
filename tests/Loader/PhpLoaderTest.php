<?php

namespace Northwoods\Config\Tests\Loader;

use PHPUnit_Framework_TestCase;
use Northwoods\Config\Loader\PhpLoader;

class PhpLoaderTest extends PHPUnit_Framework_TestCase
{
    public function testPhpLoader()
    {
        $content = PhpLoader::load(__DIR__ . '/../__files/app.php');
        $this->assertEquals('America/New_York', $content['timezone']);
    }
}
