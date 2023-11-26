<?php

namespace Src\Command;

use Src\Dto\DeleteDto;
use Src\Model\Book;
use Src\Request;
use Src\View\View;

class DeleteCommand implements Command
{
    public function handle(Request $request): void
    {
        $book = new Book();
        $bookToDelete = DeleteDto::fromData($request->book['isbn']);
        $deletedBook = $book->delete($bookToDelete);
        View::render(fileName: 'list', items: ['books' => $deletedBook]);
    }
}