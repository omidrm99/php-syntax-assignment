<?php

namespace Src;

use Src\Exception\CommandNotFoundException;
use Src\Task\Task;
use Src\Validate\Validable;

class Manager
{
    private array $commands = [];

    public function addCommand(string $commandName, string $className, ?string $validationClassName = null): void
    {
        $this->commands[$commandName] = ['class' => $className];
        if (!$validationClassName === null) {
            $this->commands[$commandName]['validation'] = $validationClassName;
        }
    }

    public function execute(Command $command): void
    {
        if (!array_key_exists($command->task, $this->commands)) {
            throw new CommandNotFoundException();
        }

        if (array_key_exists('validation', $this->commands[$command->task])) {
            $validationClass = new $this->commands[$command->task]['validation']();
            assert($validationClass instanceof Validable);
            $validationClass->validate($command);
        }

        $class = new $this->commands[$command->task]['class']();
        assert($class instanceof Task);
        $class->handle($command);
    }
}