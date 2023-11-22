<?php

namespace Src\Service\Model;

use Src\Dto\BookDto;
use Src\Dto\BookGetFilterDto;

trait BookGetFilterTrait
{
    protected function checkShouldBeFiltered(BookDto $bookDto, BookGetFilterDto $bookGetFilterDto): bool
    {
        if (in_array($bookDto->title, $bookGetFilterDto->titles)) {
            return true;
        } elseif (in_array($bookDto->authorName, $bookGetFilterDto->authors)) {
            return true;
        } elseif (in_array($bookDto->isbn, $bookGetFilterDto->isbns)) {
            return true;
        } elseif (in_array($bookDto->pageCount, $bookGetFilterDto->pages)) {
            return true;
        } elseif ($this->checkAllFiltersAreEmpty($bookGetFilterDto)) {
            return true;
        } else {
            return false;
        }
    }

    private function checkAllFiltersAreEmpty(BookGetFilterDto $bookGetFilterDto): bool
    {
        if (empty($bookGetFilterDto->pages) &&
            empty($bookGetFilterDto->titles) &&
            empty($bookGetFilterDto->isbns) &&
            empty($bookGetFilterDto->authors)) {
            return true;
        }
        return false;
    }
}