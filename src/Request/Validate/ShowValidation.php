<?php

namespace Src\Request\Validate;

use Src\Exception\ValidationException;
use src\Request\Request;
use Src\Request\Rule\Isbn13Rule;

class ShowValidation implements Validable
{

    public function getRules(): array
    {
        return [
            'isbn' => [Isbn13Rule::class]
        ];
    }
}