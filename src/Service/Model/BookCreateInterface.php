<?php

namespace Src\Service\Model;

use Src\Dto\InsertDto;

interface BookCreateInterface
{
    public function addRequestedBooks(InsertDto $insertDto): array;
}