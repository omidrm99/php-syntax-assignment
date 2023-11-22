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


try {
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
} catch (\Src\Exception\CommandNotFoundException|
\Src\Exception\ValidationException|
\Src\Exception\NotFoundException $e) {
    \Src\View\View::render('error', ['message' => $e->getMessage()]);
} catch (Exception $e) {
    \Src\View\View::render('error', ['message' => 'system failure. contact the admin']);
    // todo : write to logs
}

