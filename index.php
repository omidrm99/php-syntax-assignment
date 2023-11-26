<?php

declare(strict_types=1);


require_once __DIR__ . '/vendor/autoload.php';

use Src\Command\DeleteCommand;
use Src\Command\IndexCommand;
use Src\Command\ShowCommand;
use Src\Command\CreateCommand;
use Src\Command\UpdateCommand;
use Src\Enum\CommandName;
use Src\Manager;
use Src\Request\Request;
use Src\Request\Validate\IndexValidation;
use Src\Request\Validate\ShowValidation;

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
        ShowCommand::class,
        ShowValidation::class
);
    $manager->addCommand(
        CommandName::Create->value,
        CreateCommand::class
    );
    $manager->addCommand(
        CommandName::Delete->value,
        DeleteCommand::class
    );
    $manager->addCommand(
        CommandName::Update->value,
        UpdateCommand::class
    );

    $manager->execute($command);
} catch (\Src\Exception\CommandNotFoundException|
\Src\Exception\ValidationException|
\Src\Exception\NotFoundException $e) {
    \Src\View\View::render('error', ['message' => $e->getMessage()]);
} catch (Exception $e) {
    \Src\View\View::render('error', ['message' => 'system failure. contact the admin']);
    // todo : write to logs
}

