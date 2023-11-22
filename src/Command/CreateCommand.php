<?php

namespace Src\Command;

use Src\Dto\InsertDto;
use Src\Model\Book;
use Src\Request;

class CreateCommand implements Command
{
    public function handle(Request $request): void
    {
        $book = new Book();
        $booksToAdd = InsertDto::fromRequest($request);
        $book->add($booksToAdd);
        View::render(fileName: 'list', items: ['books' => $addedBooks]);

    }
}