<?php

namespace Src\Command;

use Src\Request;

interface Command
{
    /**
     * @param Request $request
     * @return void
     */
    public function handle(Request $request): void;

}