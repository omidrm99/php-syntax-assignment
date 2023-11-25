<?php

namespace Src\Request\Rule;

use Src\Dto\RuleParametersDto;

class IsArray implements Rule
{

    public function validate(RuleParametersDto $dto): bool
    {
        return is_array($dto->inputParameter);
    }

    public function getFailureMessage(): string
    {
        return 'your parameter should be an array';
    }
}