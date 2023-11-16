<?php

namespace Src\Service\BookIndex;

use Src\Dto\BookIndexFilterDto;

trait BookIndexFilterTrait
{
    protected function checkShouldBeFiltered(BookIndexFilterDto $book, array $authors, array $titles): bool
    {
        if (!in_array($book->titleName, $titles) && !empty($titles)) {
            return false;
        }
        if (!in_array($book->authorName, $authors) && !empty($authors)) {
            return false;
        }
        return true;
    }
}