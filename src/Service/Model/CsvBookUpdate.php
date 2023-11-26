<?php

namespace Src\Service\Model;

use Src\Dto\BookDto;

class CsvBookUpdate implements BookUpdateInterface
{
    private string $csvFilePath = __DIR__ . '/../../database/books.csv'; //todo : read from env.

    public function updateRequestedBook(BookDto $bookDto): array
    {
        $books = array_map('str_getcsv', file($this->csvFilePath));
        $flag = 0;
        foreach ($books as &$item) {
            if (($item[0] === $bookDto->isbn)) {
                $item[1] = $bookDto->title;
                $item[2] = $bookDto->authorName;
                $item[3] = $bookDto->pageCount;
                $item[4] = date('Y-m-d', $bookDto->timeStamp);

                $dto = BookDto::fromData(
                    title: $item[1],
                    authorName: $item[2],
                    isbn: $item[0],
                    pageCount: $item[3],
                    publishDate: $item[4]
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
        return [$dto];
    }
}