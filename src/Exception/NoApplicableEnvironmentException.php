<?php

namespace Neemzy\Environ\Exception;

class NoApplicableEnvironmentException extends \Exception
{
    /**
     * Constructor
     * Sets up error message
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct('No applicable environment was defined', 0, null);
    }
}
