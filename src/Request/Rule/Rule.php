<?php

namespace Src\Request\Rule;
use Src\Dto\RuleParametersDto;

interface Rule
{
    public function validate(RuleParametersDto $dto): bool;

    public function getFailureMessage(): string;
}