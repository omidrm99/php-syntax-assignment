<?php

namespace Src\Command;

use Src\Dto\BookDto;
use Src\Request;
use Src\Service\BookIndex\CsvBookIndex;
use Src\Service\BookIndex\JsonBookIndex;
use Src\View\View;

class IndexCommand implements Command
{
    public function handle(Request $request): void
    {
        $csvBooks = (new CsvBookIndex())->getRequestedBooks($request);
        $jsonBooks = (new JsonBookIndex())->getRequestedBooks($request);

        $allBooks = array_merge($csvBooks, $jsonBooks);
        $sortedBooks = $this->applyDateSort($allBooks, $request);
        $finalBooks = $this->applyPagination($sortedBooks, $request);

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
        $defaultPage = 3; //todo : add them to enum
        if (isset($request->perPage)) {
            $defaultPerPage = $request->perPage;
        }
        if (isset($request->page)) {
            $defaultPage = $request->page;
        }

        $startOffset = ($defaultPerPage * $defaultPage) - $defaultPerPage;
        $length = $startOffset + $defaultPerPage;
        return array_slice($books, $startOffset, $length);
    }
}