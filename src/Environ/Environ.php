<?php

namespace Environ;

class Environ
{
    private $envs;
    private $current;



    public function __construct()
    {
        $this->envs = array();
        $this->current = null;
    }



    public function add($name, \Closure $condition, \Closure $callback)
    {
        $this->envs[$name] = new Environment($condition, $callback);
        return $this;
    }



    public function init()
    {
        foreach ($this->envs as $name => $env) {
            try {
                if (call_user_func($env->condition)) {
                    $this->set($name);
                    break;
                }
            } catch (\Exception $e) {
                return false;
            }
        }

        return true;
    }



    public function get()
    {
        return $this->current;
    }



    public function is($name)
    {
        return $name == $this->current;
    }

    

    public function set($name)
    {
        if (! isset($this->envs[$name])) {
            return false;
        }

        $this->current = $name;

        try {
            call_user_func($this->envs[$name]->callback);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
}
