<?php

namespace Src\Service\Model;

use Src\Dto\InsertDto;

class JsonBookCreate implements BookCreateInterface
{
    private string $jsonFilePath = __DIR__ . '/../../database/books.json'; //todo : read from env.
    private string $authorsFilePath = __DIR__ . '/../../database/authors.json'; //todo : read from env.

    public function addRequestedBooks(InsertDto $insertDto): array
    {
        $booksDto = [];
        $file = file_get_contents($this->jsonFilePath);
        $books = json_decode($file, true);

        foreach ($insertDto->books as $insertItem) {
            $flag = 0;
            foreach ($books['books'] as $item) {
                if (($item['ISBN'] === $insertItem->isbn)) {
                    $flag = 1;
                }
            }
            if (!$flag) {
                $jsonFormat = [
                    'ISBN' => $insertItem->isbn,
                    'bookTitle' => $insertItem->title,
                    'authorName' => $insertItem->authorName,
                    'pagesCount' => $insertItem->pageCount,
                    'publishDate' => date('Y-m-d', $insertItem->timeStamp),
                    'deleted' => false
                ];
                $books['books'][] = $jsonFormat;
                $updatedBooks = json_encode($books, JSON_PRETTY_PRINT);
                file_put_contents($this->jsonFilePath, $updatedBooks);
                $booksDto[] = $insertItem;
                (new JsonAuthorCreate())->addAuthor($insertItem->authorName, $this->authorsFilePath);
            }
        }

        return $booksDto;
    }
}