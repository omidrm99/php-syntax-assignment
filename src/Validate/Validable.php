<?php

namespace Src\Validate;

use Src\Exception\ValidationException;
use Src\Request;

interface Validable
{
    /**
     * @param Request $request
     * @return void
     * @throws ValidationException
     */
    public function validate(Request $request): void;
}