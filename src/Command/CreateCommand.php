<?php

namespace Src\Command;

use Src\Dto\InsertDto;
use Src\Model\Book;
use Src\Request;
use Src\View\View;

class CreateCommand implements Command
{
    public function handle(Request $request): void
    {
        $book = new Book();
        $booksToAdd = InsertDto::fromRequest($request);
        $allBooks = $book->add($booksToAdd);
        View::render(fileName: 'list', items: ['books' => $allBooks]);
    }
}