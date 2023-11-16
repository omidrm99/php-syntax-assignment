<?php

namespace Src\Validate;

use Src\Command;
use Src\Exception\ValidationException;

interface Validable
{
    /**
     * @param Command $command
     * @throws ValidationException
     * @return void
     */
    public function validate(Command $command): void;
}