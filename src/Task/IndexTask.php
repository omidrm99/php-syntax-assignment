<?php

namespace Src\Task;

use Src\Command;
use Src\Dto\BookDto;
use Src\Service\BookIndex\CsvBookIndex;
use Src\Service\BookIndex\JsonBookIndex;

class IndexTask implements Task
{
    public function handle(Command $command): void
    {
        $csvBooks = (new CsvBookIndex())->getRequestedBooks($command);
        $jsonBooks = (new JsonBookIndex())->getRequestedBooks($command);

        $allBooks = array_merge($csvBooks, $jsonBooks);
        $sortedBooks = $this->applyDateSort($allBooks, $command);
        $finalBooks = $this->applyPagination($sortedBooks, $command);
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
        $defaultPage = 1; //todo : add them to enum
        if (isset($command->perPage)) {
            $defaultPerPage = $command->perPage;
        }
        if (isset($command->page)) {
            $defaultPage = $command->page;
        }

        $startOffset = $defaultPerPage * $defaultPage - 1;
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