<?php

namespace Src\Model;

use JetBrains\PhpStorm\Pure;
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
    public function get(FilterDto $filterDto): array
    {
        $data = [];
        assert($filterDto instanceof BookGetFilterDto);
        $getters = $this->getBookGetters();
        foreach ($getters as $getter) {
            assert($getter instanceof BookIndexInterface);
            $data = array_merge($data, $getter->getRequestedBooks($filterDto));
        }
        return $data;
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
}