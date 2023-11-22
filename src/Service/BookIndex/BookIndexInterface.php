<?php

namespace Src\Service\BookIndex;

use Src\Command;
use Src\Dto\BookDto;
use Src\Request;

interface BookIndexInterface
{
    /**
     * @param Request $request
     * @return BookDto[]
     */
    public function getRequestedBooks(Request $request): array;

}