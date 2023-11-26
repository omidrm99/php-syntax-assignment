<?php

namespace Src\Service\Model;

use Src\Dto\DeleteDto;

interface BookDeleteInterface
{
    public function deleteRequestedBooks(DeleteDto $deleteDto): array;
}