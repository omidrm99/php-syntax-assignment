<?php

namespace Src\Validate;

use Src\Exception\ValidationException;
use Src\Request;

interface Validable
{
    /**
     * @param Request $command
     * @throws ValidationException
     * @return void
     */
    public function validate(Request $command): void;
}