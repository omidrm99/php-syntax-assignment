<?php

namespace Src\View;

class View
{
    public static function render(string $fileName, array $items): void
    {
        include __DIR__ . './../../views/' . $fileName . '.php';
    }
}