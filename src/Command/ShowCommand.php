<?php

namespace Src\Command;

use Src\Exception\NotFoundException;
use Src\Model\Book;
use Src\Request\Request;
use Src\View\View;

class ShowCommand implements Command
{
    /**
     * @throws NotFoundException
     */
    public function handle(Request $request): void
    {
        $book = (new Book())->find($request->isbn);
        if (is_null($book)) {
            throw new NotFoundException();
        }
        View::render(fileName: 'book', items: ['book' => $book]);
    }
}