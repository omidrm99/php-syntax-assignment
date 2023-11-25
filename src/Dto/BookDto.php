<?php

namespace Src\Dto;

use Carbon\Carbon;

class BookDto
{
    public function __construct(
        public string $title,
        public string $authorName,
        public string $isbn,
        public int    $pageCount,
        public int    $timeStamp,
        public bool   $softDeleted
    )
    {
    }

    public static function fromData(
        string $title,
        string $authorName,
        string $isbn,
        int    $pageCount,
        string $publishDate,
        bool   $softDeleted
    ): self
    {
        $time = Carbon::createFromFormat('Y-m-d', $publishDate);
        return new self(
            title: $title,
            authorName: $authorName,
            isbn: $isbn,
            pageCount: $pageCount,
            timeStamp: $time->timestamp,
            softDeleted: $softDeleted
        );
    }
}