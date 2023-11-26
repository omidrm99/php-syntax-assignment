<?php

namespace Src\Service\Model;

use Src\Dto\BookDto;
use Src\Dto\DeleteDto;

class CsvBookDelete implements BookDeleteInterface
{
    private string $csvFilePath = __DIR__ . '/../../../database/books.csv'; //todo : read from env.

    public function deleteRequestedBooks(DeleteDto $deleteDto): array
    {
        $books = array_map('str_getcsv', file($this->csvFilePath));
        $flag = 0;
        foreach ($books as &$item) {
            if (($item[0] === $deleteDto->isbn)) {
                $item[5] = 'true';
                $booksDto = BookDto::fromData(
                    title: $item[1],
                    authorName: $item[2],
                    isbn: $item[0],
                    pageCount: $item[3],
                    publishDate: $item[4],
                    softDeleted: true
                );
                $flag = 1;
                break;
            }
        }
        if ($flag === 0) {
            return [];
        }
        $file = fopen($this->csvFilePath, 'w');
        foreach ($books as $row) {
            fputcsv($file, $row);
        }
        fclose($file);
        return [$booksDto];
    }
}