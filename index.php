<?php

declare(strict_types=1);




require_once __DIR__ . '/vendor/autoload.php';

use Src\Command\IndexCommand;
use Src\Command\ShowCommand;
use Src\Enum\CommandName;
use Src\Manager;
use Src\Request;

use Src\Validate\IndexValidation;

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
    ShowCommand::class);

$manager->execute($command);

