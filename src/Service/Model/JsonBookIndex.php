<?php

namespace Src\Service\Model;

use Src\Dto\BookDto;
use Src\Dto\BookGetFilterDto;

class JsonBookIndex implements BookIndexInterface
{
    use BookGetFilterTrait;

    private string $jsonFilePath = __DIR__ . '/../../database/books.json'; //todo : read from env.

    /**
     * @inheritDoc
     */
    public function getRequestedBooks(BookGetFilterDto $filterDto): array
    {
        $books = [];
        $contents = json_decode(
            file_get_contents(filename: $this->jsonFilePath)
        )->books;
        foreach ($contents as $book) {
            $dto =  BookDto::fromData(
                title: $book->bookTitle,
                authorName: $book->authorName,
                isbn: $book->ISBN,
                pageCount: $book->pagesCount,
                publishDate: $book->publishDate
            );
            if ($this->checkShouldBeFiltered($dto, $filterDto)) {
                $books[] = $dto;
            }
        }
        return $books;
    }

}