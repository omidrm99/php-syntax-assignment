<?php

namespace Src\Service\Model;

use Src\Dto\BookDto;

interface BookUpdateInterface
{
    public function updateRequestedBook(BookDto $bookDto): array;
}