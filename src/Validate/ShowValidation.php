<?php

namespace Src\Validate;

use Src\Exception\ValidationException;
use Src\Request;

class ShowValidation implements Validable
{
    /**
     * @inheritDoc
     */
    public function validate(Request $request): void
    {
        $this->checkIsbnIsValid($request);
    }

    private function checkIsbnIsValid(Request $request): void
    {
        if (!isset($request->isbns) || count($request->isbns) !== 1) {
            throw new ValidationException();
        }
    }
}