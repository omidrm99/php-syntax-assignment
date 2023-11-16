<?php

namespace Src\Dto;

class BookIndexFilterDto
{
    public function __construct(
        public string $authorName,
        public string $titleName
    )
    {
    }

    public static function fromData(
        string $authorName,
        string $titleName
    ): BookIndexFilterDto
    {
        return new self(
            authorName: $authorName, titleName: $titleName
        );
    }
}