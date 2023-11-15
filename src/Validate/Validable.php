<?php

namespace src\Validate;

use src\Command;
use src\ValidationException;

interface Validable
{
    /**
     * @param Command $command
     * @throws ValidationException
     * @return void
     */
    public function validate(Command $command): void;
}