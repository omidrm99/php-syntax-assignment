<?php

declare(strict_types=1);




require_once __DIR__ . '/vendor/autoload.php';

use Src\Enum\CommandName;
use Src\Manager;
use Src\Request;
use Src\Task\IndexCommand;
use Src\Task\ShowCommand;
use Src\Validate\IndexValidation;
use Src\Validate\ShowValidation;

const COMMAND_PATH = __DIR__ . '/commands.json';

$command = new Request(COMMAND_PATH);


$manager = new Manager();
$manager->addCommand(
    CommandName::Index->value,
    IndexCommand::class,
    IndexValidation::class
);
$manager->addCommand(
    CommandName::Show->value,
    ShowCommand::class,
    ShowValidation::class
);

$manager->execute($command);

