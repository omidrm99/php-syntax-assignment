<?php

namespace Src\Dto;

class InsertDto
{
    public function __construct(
        public array  $books,
        public string $file
    )
    {
    }

    public static function fromData(
        array  $booksList,
        string $file
    ): InsertDto
    {
        $books = [];
        foreach ($booksList as $bookItem) {
            $book = BookDto::fromData(
                title: $bookItem['title'],
                authorName: $bookItem['author'],
                isbn: $bookItem['isbn'],
                pageCount: $bookItem['pages'],
                publishDate: $bookItem['date'],
                softDeleted: false
            );
            $books[] = $book;
        }
        return new self($books, $file);
    }
}