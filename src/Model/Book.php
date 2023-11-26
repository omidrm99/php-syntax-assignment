<?php

namespace Src\Model;

use JetBrains\PhpStorm\Pure;
use Src\Dto\BookDto;
use Src\Dto\BookDto;
use Src\Dto\BookGetFilterDto;
use Src\Dto\DeleteDto;
use Src\Dto\FilterDto;
use Src\Dto\InsertDto;
use Src\Enum\FileTypes;
use Src\Service\Model\BookCreateInterface;
use Src\Service\Model\BookDeleteInterface;
use Src\Service\Model\BookIndexInterface;
use Src\Service\Model\BookUpdateInterface;
use Src\Service\Model\CsvBookCreate;
use Src\Service\Model\CsvBookDelete;
use Src\Service\Model\CsvBookIndex;
use Src\Service\Model\CsvBookUpdate;
use Src\Service\Model\JsonBookCreate;
use Src\Service\Model\JsonBookDelete;
use Src\Service\Model\JsonBookIndex;
use Src\Service\Model\JsonBookUpdate;


class Book implements Model
{
    public function indexData(): array
    {
        $indexedData = [];
        $bookGetters = $this->getBookGetters();
        foreach ($bookGetters as $bookGetter) {
            assert($bookGetter instanceof BookIndexInterface);
            $indexedData = array_merge($bookGetter->getRequestedBooks(), $indexedData);
        }
        return $indexedData;
    }

    public function get(FilterDto $filterDto): array
    {
        $filteredData = [];
        assert($filterDto instanceof BookGetFilterDto);
        $data = $this->indexData();
        foreach ($data as $datum) {
            assert($datum instanceof BookDto);
            if ($this->checkShouldBeFiltered($datum, $filterDto)) {
                $filteredData[] = $datum;
            }
        }
        return $filteredData;
    }

    public function find(string $isbn): ?BookDto
    {
        $data = $this->indexData();
        foreach ($data as $datum) {
            assert($datum instanceof BookDto);
            if ($datum->isbn === $isbn && $datum->softDeleted === false) {
                return $datum;
            }
        }
        return null;
    }

    public function add(InsertDto $insertDto): array
    {
        $bookCreateClass = $this->addBookClasses($insertDto->file);
        assert($bookCreateClass instanceof BookCreateInterface);
        return $bookCreateClass->addRequestedBooks($insertDto);
    }

    public function delete(DeleteDto $deleteDto)
    {
        $data = [];
        $bookDeleteClasses = $this->deleteBookClasses();
        foreach ($bookDeleteClasses as $deleter) {
            assert($deleter instanceof BookDeleteInterface);
            $data = array_merge($data, $deleter->deleteRequestedBooks($deleteDto));
        }
        return $data;
    }

    public function update(BookDto $bookDto)
    {
        $data = [];
        $bookUpdateClasses = $this->updateBookClasses();
        foreach ($bookUpdateClasses as $updater) {
            assert($updater instanceof BookUpdateInterface);
            $data = array_merge($data, $updater->updateRequestedBook($bookDto));
        }
        return $data;
    }

    #[Pure] private function updateBookClasses(): array
    {
        return [
            new CsvBookUpdate(),
            new JsonBookUpdate()
        ];
    }

    #[Pure] private function deleteBookClasses(): array
    {
        return [
            new CsvBookDelete(),
            new JsonBookDelete()
        ];
    }

    #[Pure] private function addBookClasses(string $file): object
    {
        return match ($file) {
            FileTypes::JSON->value => new JsonBookCreate(),
            FileTypes::CSV->value => new CsvBookCreate()
        };
    }

    #[Pure] private function getBookGetters(): array
    {
        return [
            new JsonBookIndex(),
            new CsvBookIndex()
        ];
    }

    private function checkShouldBeFiltered(BookDto $bookDto, BookGetFilterDto $bookGetFilterDto): bool
    {
        if ($bookDto->softDeleted === true) {
            return false;
        }
        if (in_array($bookDto->title, $bookGetFilterDto->titles)) {
            return true;
        } elseif (in_array($bookDto->authorName, $bookGetFilterDto->authors)) {
            return true;
        } elseif (in_array($bookDto->isbn, $bookGetFilterDto->isbns)) {
            return true;
        } elseif (in_array($bookDto->pageCount, $bookGetFilterDto->pages)) {
            return true;
        } elseif ($this->checkAllFiltersAreEmpty($bookGetFilterDto)) {
            return true;
        } else {
            return false;
        }
    }

    private function checkAllFiltersAreEmpty(BookGetFilterDto $bookGetFilterDto): bool
    {
        if (empty($bookGetFilterDto->pages) &&
            empty($bookGetFilterDto->titles) &&
            empty($bookGetFilterDto->isbns) &&
            empty($bookGetFilterDto->authors)) {
            return true;
        }
        return false;
    }
}