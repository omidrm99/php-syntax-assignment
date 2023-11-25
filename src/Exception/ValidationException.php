<?php

namespace Src\Exception;

use Throwable;

class ValidationException extends \Exception
{
    public function __construct(
        string     $message,
        int        $code = 0,
        ?Throwable $previous = null
    )
    {
        $finalMessage = 'Validation error Occurred : ' . $message;
        parent::__construct($finalMessage, $code, $previous);
    }
}