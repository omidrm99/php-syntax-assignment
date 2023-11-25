<?php

namespace Src\Service\Model;

use Src\Dto\BookDto;

class JsonBookIndex implements BookIndexInterface
{
    private string $jsonFilePath = __DIR__ . '/../../../database/books.json'; //todo : read from env.

    /**
     * @inheritDoc
     */
    public function getRequestedBooks(): array
    {
        $books = [];
        $contents = json_decode(
            file_get_contents(filename: $this->jsonFilePath)
        )->books;
        foreach ($contents as $book) {
            $books[] =  BookDto::fromData(
                title: $book->bookTitle,
                authorName: $book->authorName,
                isbn: $book->ISBN,
                pageCount: $book->pagesCount,
                publishDate: $book->publishDate
            );
        }
        return $books;
    }

}