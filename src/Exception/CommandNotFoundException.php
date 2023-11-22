<?php

namespace Src\Exception;

class CommandNotFoundException extends \Exception
{
    public function __construct(string $message = 'command not found error', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}