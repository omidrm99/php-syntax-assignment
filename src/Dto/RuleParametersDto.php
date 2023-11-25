<?php

namespace Src\Dto;

class RuleParametersDto
{
    public function __construct(
        public mixed $inputParameter
    )
    {
    }

    public static function fromData(mixed $inputParameter): RuleParametersDto
    {
        return new self($inputParameter);
    }
}