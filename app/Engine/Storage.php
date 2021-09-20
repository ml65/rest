<?php

namespace Mls65\Bulletin\Engine;

class Storage {

    /**
     * @var array storage of dependency
     */
    static private $map;
    
    static public function get($name)
    {
        return self::$map->$name;
    }

    static public function set($name, $dependency)
    {
        if(self::$map === null) {
            self::$map = (object) array();
        }
        self::$map->$name = $dependency;
    }
}
