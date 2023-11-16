<?php

declare(strict_types=1);




require_once __DIR__ . '/vendor/autoload.php';

use Src\Command;
use Src\Enum\CommandName;
use Src\Manager;
use Src\Task\IndexTask;
use Src\Task\ShowTask;
use Src\Validate\IndexValidation;
use Src\Validate\ShowValidation;

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

