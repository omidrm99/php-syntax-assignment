<?php

namespace Src\Command;

use src\Request\Request;

interface Command
{
    /**
     * @param Request $request
     * @return void
     */
    public function handle(Request $request): void;

}