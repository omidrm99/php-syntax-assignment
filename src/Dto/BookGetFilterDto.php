<?php

namespace Src\Dto;

use src\Request\Request;

class BookGetFilterDto extends FilterDto
{
    public function __construct(
        public array $isbns,
        public array $authors,
        public array $titles,
        public array $pages,
    )
    {
    }

    public static function fromRequest(
        Request $request
    ): BookGetFilterDto
    {
        return new self(
            isbns: $request->isbns ?? [],
            authors: $request->authors ?? [],
            titles: $request->titles ?? [],
            pages: $request->pages ?? []
        );
    }
}