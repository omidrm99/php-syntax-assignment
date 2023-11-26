<?php

namespace Src\Service\Model;

use Src\Dto\BookDto;
use Src\Dto\DeleteDto;

class JsonBookDelete implements BookDeleteInterface
{
    private string $jsonFilePath = __DIR__ . '/../../database/books.json'; //todo : read from env.

    public function deleteRequestedBooks(DeleteDto $deleteDto): array
    {
        $file = file_get_contents($this->jsonFilePath);
        $books = json_decode($file, true);

        $flag = 0;
        foreach ($books['books'] as &$item) {
            if (($item['ISBN'] === $deleteDto->isbn)) {
                $item['deleted'] = true;

                $booksDto = BookDto::fromData(
                    title: $item['bookTitle'],
                    authorName: $item['authorName'],
                    isbn: $item['ISBN'],
                    pageCount: $item['pagesCount'],
                    publishDate: $item['publishDate']
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