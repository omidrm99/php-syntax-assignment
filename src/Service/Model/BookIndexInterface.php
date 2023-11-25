<?php

namespace Src\Service\Model;

use Src\Dto\BookDto;
use Src\Dto\BookGetFilterDto;

interface BookIndexInterface
{
    /**
     * @param BookGetFilterDto $filterDto
     * @return BookDto[]
     */
    public function getRequestedBooks(BookGetFilterDto $filterDto): array;

}