<?php

namespace Neemzy\Environ;

class Environment
{
    public $condition;
    public $callback;



    public function __construct(\Closure $condition, \Closure $callback)
    {
        $this->condition = $condition;
        $this->callback = $callback;
    }
}
