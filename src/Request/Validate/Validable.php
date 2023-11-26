<?php

namespace Src\Request\Validate;

use Src\Exception\ValidationException;

interface Validable
{
    /**
     * @return array
     * @throws ValidationException
     */
    public function getRules(): array;
}