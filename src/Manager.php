<?php

namespace Neemzy\Environ;

class Manager
{
    /**
     * @var array Environment collection
     */
    protected $environments;

    /**
     * @var string Current environment's name
     */
    protected $current;



    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->environments = array();
        $this->current = null;
    }



    /**
     * Adds an environment to this instance's collection
     *
     * @param string                     $name        Environment name
     * @param Neemzy\Environ\Environment $environment Environment instance
     *
     * @return Neemzy\Environ\Manager Self (for chaining)
     */
    public function add($name, Environment $environment)
    {
        $this->environments[$name] = $environment;

        return $this;
    }



    /**
     * Initializes environments
     *
     * @return void
     */
    public function init()
    {
        foreach ($this->environments as $name => $environment) {
            if ($environment->test()) {
                $this->set($name);
                break;
            }
        }

        if (null == $this->current) {
            throw new \Exception('No applicable environment was defined');
        }
    }



    /**
     * Gets current environment's name
     *
     * @return string
     */
    public function get()
    {
        return $this->current;
    }



    /**
     * Checks if current environment's name is expected value
     *
     * @param string $name Excepted current environment name
     *
     * @return bool
     */
    public function is($name)
    {
        return $name == $this->current;
    }



    /**
     * Sets current environment
     *
     * @param string $name Environment name
     *
     * @throws UndefinedEnvironmentException
     * @return void
     */
    public function set($name)
    {
        if (!isset($this->environments[$name])) {
            throw new UndefinedEnvironmentException($name);
        }

        $this->current = $name;
        $this->environments[$name]->run();
    }
}
