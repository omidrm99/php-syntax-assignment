<?php

namespace Src\Validate;

use Src\Enum\SortTypes;
use src\Exception\ValidationException;
use Src\Request;

class IndexValidation implements Validable
{
    public function validate(Request $request): void
    {
        if (isset($request->page)) {
            if (!gettype($request->page) === 'integer') {
                throw new ValidationException();
            }
        }
        if (isset($request->page)) {
            if (!gettype($request->perPage) === 'integer') {
                throw new ValidationException();
            }
        }
        if (isset($request->sort)) {
            $validValues = [];
            $types = SortTypes::cases();
            foreach ($types as $type) {
                $validValues[] = $type->value;
            }
            if (in_array($request->sort, $validValues)) {
                throw new ValidationException();
            }
        }
    }
}