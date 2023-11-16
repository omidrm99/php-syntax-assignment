<?php

namespace Src\Validate;

use Src\Command;
use Src\Enum\SortTypes;
use src\Exception\ValidationException;

class IndexValidation implements Validable
{
    public function validate(Command $command): void
    {
        if (isset($command->page)) {
            if (!gettype($command->page) === 'integer') {
                throw new ValidationException();
            }
        }
        if (isset($command->page)) {
            if (!gettype($command->perPage) === 'integer') {
                throw new ValidationException();
            }
        }
        if (isset($command->sort)) {
            $validValues = [];
            $types = SortTypes::cases();
            foreach ($types as $type) {
                $validValues[] = $type->value;
            }
            if (in_array($command->sort, $validValues)) {
                throw new ValidationException();
            }
        }
    }
}