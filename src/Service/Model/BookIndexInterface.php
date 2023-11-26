<?php

namespace Src\Service\Model;

use Src\Dto\BookDto;
use Src\Dto\BookGetFilterDto;

interface BookIndexInterface
{
    /**
     * @return BookDto[]
     */
    public function getRequestedBooks(): array;

}