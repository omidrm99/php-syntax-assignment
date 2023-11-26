<?php

namespace Src\Request\Rule;

use Src\Dto\RuleParametersDto;

class RequiredRule implements Rule
{
    public ?string $parameter = null;

    public function validate(RuleParametersDto $dto): bool
    {
        $this->parameter = $dto->inputParameter;
        return !is_null($dto->inputParameter);
    }

    public function getFailureMessage(): string
    {
        return 'this parameter is required : ' . $this->parameter;
    }
}