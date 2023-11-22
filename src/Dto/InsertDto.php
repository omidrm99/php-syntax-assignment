<?php

namespace Src\Dto;

use Src\Request;

class InsertDto
{
    public function __construct(
        public array $books
    )
    {
    }

    public static function fromRequest(
        Request $request
    ): InsertDto
    {
        foreach ($request as $requestItem) {
            $books = [];
            $book = BookDto::fromData(
                title: $requestItem->title,
                authorName: $requestItem->author,
                isbn: $requestItem->isbn,
                pageCount: $requestItem->pages,
                publishDate: $requestItem->date
            );
            $books[] = $book;
        }
            return new self($books);
    }
}