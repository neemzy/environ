<?php

namespace Neemzy\Environ\Exception;

class NoApplicableEnvironmentException extends \Exception
{
    public function __construct()
    {
        parent::__construct('No applicable environment was defined');
    }
}
