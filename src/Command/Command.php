<?php

namespace Src\Task;

use Src\Request;

interface Command
{
    /**
     * @param Request $command
     * @return void
     */
    public function handle(Request $command): void;

    public function view(mixed $sources): void;
}