<?php

namespace Src\DB;

interface Database
{
    /**
     * @param PrepareDto $dto
     */
    public function read(PrepareDto $dto): array;

    /**
     * @param ManipulationDto $manipulationDto
     * @return ResourceDto
     */
    public function update(ManipulationDto $manipulationDto): ResourceDto;

    /**
     * @param OmitDto $omitDto
     * @return void
     */
    public function delete(OmitDto $omitDto): void;

}