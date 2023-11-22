<?php

namespace Src\Exception;

class NotFoundException extends \Exception
{
    public function __construct(
        string $message = 'Resource not found Error',
        int    $code = 0, ?Throwable $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
    }
}