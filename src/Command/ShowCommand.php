<?php

namespace Src\Command;

use Src\Dto\BookGetFilterDto;
use Src\Exception\NotFoundException;
use Src\Model\Book;
use Src\Request;
use Src\View\View;

class ShowCommand implements Command
{
    /**
     * @throws NotFoundException
     */
    public function handle(Request $request): void
    {
        $book = (new Book())->get(BookGetFilterDto::fromRequest($request));
        if (empty($book)) {
            throw new NotFoundException();
        }
        View::render(fileName: 'book', items: ['book' => $book[0]]);
    }
}