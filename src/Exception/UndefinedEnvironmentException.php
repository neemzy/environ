<?php

namespace Neemzy\Environ\Exception;

class UndefinedEnvironmentException extends \Exception
{
    /**
     * Constructor
     * Sets up error message
     *
     * @param string $name Requested environment name
     *
     * @return void
     */
    public function __construct($name)
    {
        parent::__construct('The environment "'.$name.'" is undefined', 0, null);
    }
}
