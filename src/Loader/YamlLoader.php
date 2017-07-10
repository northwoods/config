<?php

namespace Northwoods\Config\Loader;

use Symfony\Component\Yaml\Parser;

class YamlLoader implements LoaderInterface
{
    public static function isSupported()
    {
        return class_exists(Parser::class);
    }

    /**
     * @var Parser
     */
    private $parser;

    public function __construct()
    {
        $this->parser = new Parser();
    }

    public function load($path)
    {
        if (is_file("$path.yaml")) {
            return $this->parser->parse(file_get_contents("$path.yaml"));
        } else {
            return [];
        }
    }
}
