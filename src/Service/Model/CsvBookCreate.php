<?php

namespace Src\Service\Model;

use Src\Dto\InsertDto;

class CsvBookCreate implements BookCreateInterface
{

    private string $csvFilePath = __DIR__ . '/../../../database/books.csv'; //todo : read from env.
    private string $authorsFilePath = __DIR__ . '/../../../database/authors.json'; //todo : read from env.

    public function addRequestedBooks(InsertDto $insertDto): array
    {
        $booksDto = [];
        $books = [];
        $file = fopen($this->csvFilePath, 'a+');
        fgetcsv($file);
        while (($book = fgetcsv($file)) !== false) {
            $books[] = $book;
        }
        foreach ($insertDto->books as $insertItem) {
            $flag = 0;
            foreach ($books as $item) {
                if (($item[0] === $insertItem->isbn)) {
                    $flag = 1;
                }
            }
            if (!$flag) {
                $csvFormat = [
                    $insertItem->isbn,
                    $insertItem->title,
                    $insertItem->authorName,
                    $insertItem->pageCount,
                    date('Y-m-d', $insertItem->timeStamp),
                    'false'
                ];
                fputcsv($file, $csvFormat);
                $booksDto[] = $insertItem;
                (new JsonAuthorCreate())->addAuthor($insertItem->authorName, $this->authorsFilePath);
            }
        }
        fclose($file);
        return $booksDto;
    }
}