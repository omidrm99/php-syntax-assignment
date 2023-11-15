<?php

namespace src\Task;

use src\Command;

interface Task
{
    /**
     * @param Command $command
     * @return mixed
     */
    public function handle(Command $command): mixed;
}