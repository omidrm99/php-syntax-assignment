<?php

namespace Src\Command;

use Src\Dto\BookDto;
use Src\Dto\BookGetFilterDto;
use Src\Model\Book;
use src\Request\Request;
use Src\View\View;

class IndexCommand implements Command
{
    public function handle(Request $request): void
    {
        $book = new Book();
        $filterDto = BookGetFilterDto::fromRequest($request);
        $allBooks = $book->get($filterDto);
        $sortedBooks = $this->applyDateSort($allBooks, $request); // todo : we need a service
        $finalBooks = $this->applyPagination($sortedBooks, $request); //todo : we need a service
        View::render(fileName: 'list', items: ['books' => $finalBooks]);
    }

    /**
     * @param BookDto[] $allBooks
     * @return BookDto[]
     */
    private function applyDateSort(array $allBooks, Request $request): array
    {
        usort($allBooks, function (BookDto $firstDto, BookDto $secondDto) {
            return $firstDto->timeStamp - $secondDto->timeStamp;
        });
        if (isset($request->sort)) {
            if ($request->sort === 'DESC') {
                return array_reverse($allBooks);
            }
        }
        return $allBooks;
    }

    private function applyPagination(array $books, Request $request): array
    {
        $defaultPerPage = 4;
        $defaultPage = 1; //todo : add them to enum
        if (isset($request->perPage)) {
            $defaultPerPage = $request->perPage;
        }
        if (isset($request->page)) {
            $defaultPage = $request->page;
        }
        $lastOffset = ($defaultPerPage * $defaultPage);
        $firstOffset = $lastOffset - $defaultPerPage;
        return array_slice($books, $firstOffset, $lastOffset - $firstOffset);
    }

}