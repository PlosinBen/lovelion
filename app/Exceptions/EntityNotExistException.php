<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class EntityNotExistException extends Exception
{
    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        parent::__construct('Entity Not Exist', $code, $previous);
    }
}
