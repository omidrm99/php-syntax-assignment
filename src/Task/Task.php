<?php

namespace Src\Task;

use Src\Command;

interface Task
{
    /**
     * @param Command $command
     * @return mixed
     */
    public function handle(Command $command): void;

    public function view(mixed $sources): void;
}