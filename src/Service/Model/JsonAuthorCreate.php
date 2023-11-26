<?php

namespace Src\Service\Model;

class JsonAuthorCreate implements AuthorCreateInterface
{
    public function addAuthor(string $authorName, string $authorsFilePath)
    {
        $authorsFile = file_get_contents($authorsFilePath);
        $authors = json_decode($authorsFile, true);
        if (!in_array($authorName, $authors['authors'])) {
            $authors['authors'][] = $authorName;
            $updatedAuthors = json_encode($authors, JSON_PRETTY_PRINT);
            file_put_contents($authorsFilePath, $updatedAuthors);
        }
    }
}