<?php

namespace Src\Enum;

enum CommandName: string
{
    case Index = 'index';
    case Show = 'show';
    case Create = 'create';
    case Delete = 'delete';
    case Update = 'update';
}
