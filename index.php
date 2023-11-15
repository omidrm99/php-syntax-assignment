<?php

declare(strict_types=1);


use src\Command;
use src\Enum\CommandName;
use src\Manager;
use src\Task\IndexTask;
use src\Task\ShowTask;
use src\Validate\IndexValidation;
use src\Validate\ShowValidation;

require_once __DIR__ . '/vendor/autoload.php';

const COMMAND_PATH = __DIR__ . '/commands.json';

$command = new Command(COMMAND_PATH);


$manager = new Manager();
$manager->addCommand(
    CommandName::Index->value,
    IndexTask::class,
    IndexValidation::class
);
$manager->addCommand(
    CommandName::Show->value,
    ShowTask::class,
    ShowValidation::class
);

$manager->execute($command);