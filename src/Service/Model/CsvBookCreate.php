<?php

namespace Src\Service\Model;

use Src\Dto\BookDto;
use Src\Dto\InsertDto;

class CsvBookCreate implements BookCreateInterface
{

    private string $csvFilePath = __DIR__ . '/../../database/books.csv'; //todo : read from env.
    private string $authorsFilePath = __DIR__ . '/../../database/authors.json'; //todo : read from env.

    public function addRequestedBooks(InsertDto $insertDto): array
    {
        $booksDto = [];
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
            $booksDto[] = $dto;
        }
        foreach ($insertDto as $insertItem) {
            if (!in_array($insertItem, $booksDto)) {
                $csvFormat = [
                    $insertItem->isbn,
                    $insertItem->title,
                    $insertItem->authorName,
                    $insertItem->pageCount,
                    $insertItem->publishDate
                ];
                fputcsv($file, $csvFormat);
                $booksDto[] = $insertItem;
            }
            $this->addAuthor($insertItem->authorName);
        }
        fclose($file);
        return $booksDto;
    }

    private function addAuthor(string $authorName)
    {
        $authorsFile = file_get_contents($this->authorsFilePath);
        $authors = json_decode($authorsFile, true);
        foreach ($authors as $ignored) {
            if (!in_array($authorName, $authors)) {
                $authors['authors'][] = $authorName;
            }
        }
        $updatedAuthors = json_encode($authors, JSON_PRETTY_PRINT);
        file_put_contents($authorsFile, $updatedAuthors);
    }
}