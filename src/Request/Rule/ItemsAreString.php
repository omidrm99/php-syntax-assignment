<?php

namespace Src\Request\Rule;

use Src\Dto\RuleParametersDto;

class ItemsAreString implements Rule
{

    public function validate(RuleParametersDto $dto): bool
    {
        return is_string($dto->inputParameter);
    }

    public function getFailureMessage(): string
    {
        return 'your parameter isn not string';
    }
}