<?php

namespace Src\Command;

use Src\Dto\BookDto;
use Src\Model\Book;
use Src\Request\Request;
use Src\View\View;

class UpdateCommand implements Command
{
    public function handle(Request $request): void
    {
        $book = new Book();
        $requestParams = $request->book;
        $bookToUpdate = BookDto::fromData(
            title: $requestParams['title'],
            authorName: $requestParams['author'],
            isbn: $requestParams['isbn'],
            pageCount: $requestParams['pages'],
            publishDate: $requestParams['date'],
            softDeleted: false
        );
        $updatedBook = $book->update($bookToUpdate);
        View::render(fileName: 'list', items: ['books' => $updatedBook]);
    }
}