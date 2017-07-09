<?php

namespace Northwoods\Config\Path;

use Exception;
use Northwoods\Config\ArrayCollection;

/**
 * @method Path get($key)
 */
class PathCollection extends ArrayCollection
{
    /**
     * @param string|Path $path
     * @return bool
     * @throws Exception
     */
    public function add($path)
    {
        if (!$path instanceof Path) {
            $path = new Path($path);
        }
        $this->container[] = $path;
        return true;
    }
}
