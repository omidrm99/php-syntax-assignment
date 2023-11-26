<?php

namespace Src\Request\Rule;

use Src\Dto\RuleParametersDto;

class Isbn13Rule implements Rule
{
    public function validate(RuleParametersDto $dto): bool
    {
        return
            is_string($dto->inputParameter) &&
            $dto->inputParameter[3] === '-' &&
            strlen($dto->inputParameter) === 14;
    }

    public function getFailureMessage(): string
    {
        return 'your parameter does not obey 13-ISBN rules obey';
    }
}