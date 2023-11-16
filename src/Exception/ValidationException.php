<?php

namespace Src\Exception;

class ValidationException extends \Exception
{
    public function __construct(
        string     $message = "Validation error Occurred",
        int        $code = 0,
        ?Throwable $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
    }
}