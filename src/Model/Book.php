<?php

namespace Src\Model;

use Src\Dto\BookGetFilterDto;
use Src\Dto\FilterDto;
use Src\Service\Model\BookIndexInterface;
use Src\Service\Model\CsvBookIndex;
use Src\Service\Model\JsonBookIndex;


class Book implements Model
{
    public function get(FilterDto $filterDto): array
    {
        $data = [];
        assert($filterDto instanceof BookGetFilterDto);
        $getters = $this->getBookGetters();
        foreach ($getters as $getter){
            assert($getter instanceof BookIndexInterface);
            $data = array_merge($data, $getter->getRequestedBooks($filterDto));
        }
        return $data;
    }

    private function getBookGetters(): array
    {
        return [
            new JsonBookIndex(),
            new CsvBookIndex()
        ];
    }
}