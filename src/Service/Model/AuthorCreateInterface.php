<?php

namespace Src\Service\Model;

interface AuthorCreateInterface
{
    public function addAuthor(string $authorName, string $authorsFilePath);
}