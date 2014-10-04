<?php

namespace Neemzy\Environ;

class Environment
{
    /**
     * @var \Closure Condition closure
     */
    protected $condition;

    /**
     * @var \Closure Callback closure
     */
    protected $callback;



    /**
     * Constructor
     *
     * @param Closure $condition Condition closure
     * @param Closure $callback Callback closure
     *
     * @return void
     */
    public function __construct(\Closure $condition, \Closure $callback)
    {
        $this->condition = $condition;
        $this->callback = $callback;
    }



    /**
     * Checks if this instance's conditions are fulfilled
     *
     * @return bool Condition closure result
     */
    public function test()
    {
        return !!call_user_func($this->condition);
    }



    /**
     * Executes this instance's callback
     *
     * @return void
     */
    public function run()
    {
        call_user_func($this->callback);
    }
}
