<?php

namespace Src\Service\Model;

use Src\Dto\BookDto;

class CsvBookIndex implements BookIndexInterface
{
    use BookGetFilterTrait;

    private string $csvFilePath = __DIR__ . '/../../database/books.csv'; //todo : read from env.

    /**
     * @inheritDoc
     */
    public function getRequestedBooks(\Src\Dto\BookGetFilterDto $filterDto): array
    {
        $books = [];
        $file = fopen($this->csvFilePath, 'r');
        fgetcsv($file);
        while (($book = fgetcsv($file)) !== false) {
            $dto = BookDto::fromData(
                title: $book[1],
                authorName: $book[2],
                isbn: $book[0],
                pageCount: $book[3],
                publishDate: $book[4]
            );
            if ($this->checkShouldBeFiltered($dto, $filterDto)) {
                $books[] = $dto;
            }
        }
        fclose($file);
        return $books;
    }

}