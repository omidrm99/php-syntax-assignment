<?php

namespace Src\Task;

use Src\Dto\BookDto;
use Src\Request;
use Src\Service\BookIndex\CsvBookIndex;
use Src\Service\BookIndex\JsonBookIndex;

class IndexCommand implements Command
{
    public function handle(Request $request): void
    {
        $csvBooks = (new CsvBookIndex())->getRequestedBooks($request);
        $jsonBooks = (new JsonBookIndex())->getRequestedBooks($request);

        $allBooks = array_merge($csvBooks, $jsonBooks);
        $sortedBooks = $this->applyDateSort($allBooks, $request);
        $finalBooks = $this->applyPagination($sortedBooks, $request);
        $this->view($finalBooks);
    }

    /**
     * @param BookDto[] $allBooks
     * @return BookDto[]
     */
    private function applyDateSort(array $allBooks, Command $command): array
    {
        usort($allBooks, function (BookDto $firstDto, BookDto $secondDto) {
            return $firstDto->timeStamp - $secondDto->timeStamp;
        });
        if (isset($command->sort)) {
            if ($command->sort === 'DESC') {
                return array_reverse($allBooks);
            }
        }
        return $allBooks;
    }

    private function applyPagination(array $books, Command $command): array
    {
        $defaultPerPage = 4;
        $defaultPage = 3; //todo : add them to enum
        if (isset($command->perPage)) {
            $defaultPerPage = $command->perPage;
        }
        if (isset($command->page)) {
            $defaultPage = $command->page;
        }

        $startOffset = ($defaultPerPage * $defaultPage) - $defaultPerPage;
        $length = $startOffset + $defaultPerPage;
        return array_slice($books, $startOffset, $length);
    }

    public function view(mixed $sources): void
    {
        foreach ($sources as $source) {
            assert($source instanceof BookDto);
            echo '<pre>';
            echo $source->isbn . '<br>';
            echo $source->title . '<br>';
            echo $source->authorName . '<br>';
            echo $source->pageCount . '<br>';
            echo $source->timeStamp . '<br>';
            echo '</pre>';
            echo '<hr>';
        }
    }
}