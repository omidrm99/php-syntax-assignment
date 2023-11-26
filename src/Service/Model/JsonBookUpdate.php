<?php

namespace Src\Service\Model;

use Src\Dto\BookDto;

class JsonBookUpdate implements BookUpdateInterface
{
    private string $jsonFilePath = __DIR__ . '/../../../database/books.json'; //todo : read from env.

    public function updateRequestedBook(BookDto $bookDto): array
    {
        $file = file_get_contents($this->jsonFilePath);
        $books = json_decode($file, true);

        $flag = 0;
        foreach ($books['books'] as &$item) {
            if (($item['ISBN'] === $bookDto->isbn)) {
                $item['bookTitle'] = $bookDto->title;
                $item['authorName'] = $bookDto->authorName;
                $item['pagesCount'] = $bookDto->pageCount;
                $item['publishDate'] = date('Y-m-d', $bookDto->timeStamp);

                $booksDto = BookDto::fromData(
                    title: $item['bookTitle'],
                    authorName: $item['authorName'],
                    isbn: $item['ISBN'],
                    pageCount: $item['pagesCount'],
                    publishDate: $item['publishDate'],
                    softDeleted: $item['softDeleted']
                );
                $flag = 1;
                break;
            }
        }
        if ($flag === 0) {
            return [];
        }
        $updatedBooks = json_encode($books, JSON_PRETTY_PRINT);
        file_put_contents($this->jsonFilePath, $updatedBooks);

        return [$booksDto];
    }
}