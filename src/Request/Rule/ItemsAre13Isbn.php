<?php

namespace Src\Request\Rule;

use Src\Dto\RuleParametersDto;

class ItemsAre13Isbn implements Rule
{

    public function validate(RuleParametersDto $dto): bool
    {
        foreach ($dto->inputParameter as $item) {
            if (!(new Isbn13Rule())->validate(RuleParametersDto::fromData($item))) {
                return false;
            }
        }
        return true;
    }

    public function getFailureMessage(): string
    {
        return 'one of your items are not in isbn 13 format';
    }
}