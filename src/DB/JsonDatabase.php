<?php

namespace Src\DB;

class JsonDatabase implements Database
{

    /**
     * @inheritDoc
     */
    public function read(PrepareDto $dto): array
    {

    }

    /**
     * @inheritDoc
     */
    public function update(ManipulationDto $manipulationDto): ResourceDto
    {
        // TODO: Implement update() method.
    }

    /**
     * @inheritDoc
     */
    public function delete(OmitDto $omitDto): void
    {
        // TODO: Implement delete() method.
    }
}