<?php

namespace Environ;

class Environ
{
    private static $instances = array();
    private static $current = null;

    private $name;
    private $condition;
    private $callback;



    public function __construct($name, \Closure $condition, \Closure $callback)
    {
        $this->name = $name;
        $this->condition = $condition;
        $this->callback = $callback;

        self::$instances[$name] = $this;
    }



    public static function init()
    {
        foreach (self::$instances as $instance) {
            if ($instance->condition()) {
                self::set($instance->name);
                break;
            }
        }
    }



    public static function get()
    {
        return self::$current;
    }



    public static function is($name)
    {
        return $name == self::$current;
    }

    

    public static function set($name)
    {
        if (isset(self::$instances[$name])) {
            self::$current = $name;
            self::$instances[self::$current]->callback();
        }
    }
}
