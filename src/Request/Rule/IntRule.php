<?php

namespace Src\Request\Rule;

use Src\Dto\RuleParametersDto;

class IntRule implements Rule
{
    public function validate(RuleParametersDto $dto): bool
    {
        return is_int($dto->inputParameter);
    }

    public function getFailureMessage(): string
    {
        return 'your parameter should be an integer';
    }
}
