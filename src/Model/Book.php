<?php

namespace Src\Model;

use JetBrains\PhpStorm\Pure;
use Src\Dto\BookGetFilterDto;
use Src\Dto\FilterDto;
use Src\Dto\InsertDto;
use Src\Service\Model\BookIndexInterface;
use Src\Service\Model\CsvBookCreate;
use Src\Service\Model\CsvBookIndex;
use Src\Service\Model\JsonBookIndex;


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
        $data = [];
        $bookCreateClasses = $this->addBookClasses();
        foreach ($bookCreateClasses as $adder) {
            $data = array_merge($data, $adder->addRequestedBooks($insertDto));
        }
        return $data;
    }

    #[Pure] private function addBookClasses(): array
    {
        return [
            new CsvBookCreate()
        ];
    }

    private function getBookGetters(): array
    {
        return [
            new JsonBookIndex(),
            new CsvBookIndex()
        ];
    }
}