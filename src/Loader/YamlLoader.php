<?php
declare(strict_types=1);

namespace Northwoods\Config\Loader;

use Symfony\Component\Yaml\Parser;

class YamlLoader implements LoaderInterface
{
    public static function isSupported(): bool
    {
        return class_exists(Parser::class);
    }

    /** @var Parser */
    private $parser;

    public function __construct(Parser $parser = null)
    {
        $this->parser = $parser ?? new Parser();
    }

    public function load(string $path): array
    {
        if (is_file("$path.yaml")) {
            return $this->parser->parse(file_get_contents("$path.yaml"));
        }

        return [];
    }
}
