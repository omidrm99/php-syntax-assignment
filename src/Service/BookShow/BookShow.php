<?php

namespace Src\Service\BookShow;

use Src\Dto\BookDto;
use Src\Request;

interface BookShow
{
    public function show(Request $request): ?BookDto;
}