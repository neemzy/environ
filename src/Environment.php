<?php

namespace Neemzy\Environ;

class Environment
{
    /** @var \Closure */
    protected $condition;

    /** @var \Closure */
    protected $callback;

    /**
     * @param \Closure $condition
     * @param \Closure $callback
     */
    public function __construct(\Closure $condition, \Closure $callback = null)
    {
        $this->condition = $condition;
        $this->callback = $callback;
    }

    /**
     * @return bool
     */
    public function test()
    {
        return !!call_user_func($this->condition);
    }

    public function run()
    {
        if (is_callable($this->callback)) {
            call_user_func($this->callback);
        }
    }
}
