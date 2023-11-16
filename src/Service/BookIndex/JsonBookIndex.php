<?php

namespace Src\Service\BookIndex;

use Src\Command;
use Src\Dto\BookDto;
use Src\Dto\BookIndexFilterDto;

class JsonBookIndex implements BookIndexInterface
{
    use BookIndexFilterTrait;

    private string $jsonFilePath = __DIR__ . '/../../database/books.json'; //todo : read from env.

    /**
     * @inheritDoc
     */
    public function getRequestedBooks(Command $command): array
    {
        $books = [];
        $contents = json_decode(
            file_get_contents(filename: $this->jsonFilePath)
        )->books;
        foreach ($contents as $book) {
            $filterIndexDto = BookIndexFilterDto::fromData(authorName: $book->authorName, titleName: $book->bookTitle);
            if ($this->checkShouldBeFiltered($filterIndexDto, $command->authors ?? [], $command->titles ?? [])) {
                $books[] = BookDto::fromData(
                    title: $book->bookTitle,
                    authorName: $book->authorName,
                    isbn: $book->ISBN,
                    pageCount: $book->pagesCount,
                    publishDate: $book->publishDate
                );
            }
        }
        return $books;
    }
}