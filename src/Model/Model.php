<?php

namespace Src\Model;

use Src\Dto\BookGetFilterDto;
use Src\Dto\FilterDto;
use Src\Dto\SourceDto;

interface Model{

    /**
     * @param FilterDto $filterDto
     * @return SourceDto[]
     */
    public function get(FilterDto $filterDto): array;
}