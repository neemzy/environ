<?php

namespace Neemzy\Environ\Exception;

class UndefinedEnvironmentException extends \Exception
{
    /**
     * @param string $name
     */
    public function __construct($name)
    {
        parent::__construct('The environment "'.$name.'" is undefined');
    }
}
