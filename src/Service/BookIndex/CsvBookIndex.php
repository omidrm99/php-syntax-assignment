<?php

namespace Src\Service\BookIndex;

use Src\Command;
use Src\Dto\BookDto;
use Src\Dto\BookIndexFilterDto;

class CsvBookIndex implements BookIndexInterface
{
    use BookIndexFilterTrait;

    private string $csvFilePath = __DIR__ . '/../../database/books.csv'; //todo : read from env.

    /**
     * @inheritDoc
     */
    public function getRequestedBooks(Command $command): array
    {
        $books = [];
        $file = fopen($this->csvFilePath, 'r');
        fgetcsv($file);
        while (($book = fgetcsv($file)) !== false) {
            $filterIndexDto = BookIndexFilterDto::fromData(authorName: $book[2], titleName: $book[1]);
            if ($this->checkShouldBeFiltered($filterIndexDto, $command->authors ?? [], $command->titles ?? [])) {
                $books[] = BookDto::fromData(
                    title: $book[1],
                    authorName: $book[2],
                    isbn: $book[0],
                    pageCount: $book[3],
                    publishDate: $book[4]
                );
            }
        }
        fclose($file);
        return $books;
    }

}