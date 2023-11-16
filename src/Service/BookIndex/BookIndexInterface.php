<?php

namespace Src\Service\BookIndex;

use Src\Command;
use Src\Dto\BookDto;

interface BookIndexInterface
{
    /**
     * @param Command $command
     * @return BookDto[]
     */
    public function getRequestedBooks(Command $command): array;

}