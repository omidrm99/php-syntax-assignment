<?php

namespace Src\Request\Validate;

use Src\Request\Rule\IntRule;
use Src\Request\Rule\IsArray;
use Src\Request\Rule\ItemsAre13Isbn;
use Src\Request\Rule\ItemsAreString;
use Src\Request\Rule\SortRule;

class IndexValidation implements Validable
{
    public function getRules(): array
    {
        return [
            'page' => [IntRule::class, SortRule::class],
            'perPage' => [IntRule::class],
            'isbns' => [IsArray::class, ItemsAre13Isbn::class],
            'authors' => [IsArray::class, ItemsAreString::class],
            'sort' => [SortRule::class]
        ];
    }
}