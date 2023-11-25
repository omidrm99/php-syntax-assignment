<?php

namespace Src\Request\Validate;

use Src\Exception\ValidationException;
use src\Request\Request;
use Src\Request\Rule\Isbn13Rule;
use Src\Request\Rule\RequiredRule;

class ShowValidation implements Validable
{

    public function getRules(): array
    {
        return [
            'isbn' => [RequiredRule::class, Isbn13Rule::class]
        ];
    }
}