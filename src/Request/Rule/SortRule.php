<?php

namespace Src\Request\Rule;

use Src\Dto\RuleParametersDto;
use Src\Enum\SortTypes;

class SortRule implements Rule
{

    public function validate(RuleParametersDto $dto): bool
    {
        if (!is_null($dto->inputParameter)) {
            $validValues = [];
            $types = SortTypes::cases();
            foreach ($types as $type) {
                $validValues[] = $type->value;
            }
            if (in_array($dto->inputParameter, $validValues)) {
                return true;
            }
            return false;
        }
        return true;
    }

    public function getFailureMessage(): string
    {
        return 'sort parameter is not set truly';
    }
}