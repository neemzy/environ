<?php

namespace Neemzy\Environ;

use Neemzy\Environ\Environment;
use Neemzy\Environ\Exception\UndefinedEnvironmentException;
use Neemzy\Environ\Exception\NoApplicableEnvironmentException;

class Manager
{
    /** @var Environment[] */
    protected $environments = array();

    /** @var string|null */
    protected $current;

    public function __construct()
    {
        $this->environments = array();
        $this->current = null;
    }

    /**
     * @param string      $name
     * @param Environment $environment
     *
     * @return Manager
     */
    public function add($name, Environment $environment)
    {
        $this->environments[$name] = $environment;

        return $this;
    }

    /**
     * @throws NoApplicableEnvironmentException
     */
    public function init()
    {
        foreach ($this->environments as $name => $environment) {
            if ($environment->test()) {
                $this->set($name);
                break;
            }
        }

        if (null === $this->current) {
            throw new NoApplicableEnvironmentException();
        }
    }

    /**
     * @return string
     */
    public function get()
    {
        return $this->current;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function is($name)
    {
        return $name == $this->current;
    }

    /**
     * @param string $name
     *
     * @throws UndefinedEnvironmentException
     */
    public function set($name)
    {
        if (!array_key_exists($name, $this->environments)) {
            throw new UndefinedEnvironmentException($name);
        }

        $this->current = $name;
        $this->environments[$name]->run();
    }
}
