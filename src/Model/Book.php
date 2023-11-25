<?php

namespace Src\Model;

use Src\Dto\BookDto;
use Src\Dto\BookGetFilterDto;
use Src\Dto\FilterDto;
use Src\Service\Model\BookIndexInterface;
use Src\Service\Model\CsvBookIndex;
use Src\Service\Model\JsonBookIndex;


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

    private function getBookGetters(): array
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