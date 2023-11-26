<?php

namespace Src\Dto;

use JetBrains\PhpStorm\Pure;

class DeleteDto
{
    public function __construct(
        public string $isbn
    )
    {
    }

    #[Pure] public static function fromData(string $isbn): DeleteDto
    {
        return new self($isbn);
    }
}