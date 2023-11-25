<?php

namespace Src;

use Exception;
use Src\Command\Command;
use Src\Dto\CommandDto;
use Src\Exception\CommandNotFoundException;
use Src\Exception\ValidationException;
use src\Request\Request;

class Manager
{
    private array $commands = [];

    /**
     * @throws Exception
     */
    public function addCommand(string $commandName, string $className, ?string $validationClassName = null): void
    {
        $this->checkForDuplicate($commandName);
        $this->commands[] = CommandDto::fromData(
            commandName: $commandName,
            className: $className,
            validator: $validationClassName
        );
    }

    /**
     * @throws CommandNotFoundException
     * @throws ValidationException
     */
    public function execute(Request $request): void
    {
        $command = $this->findRelatedCommand($request->task);

        assert($command instanceof CommandDto);
        $this->validateRequest($command->validator, $request);

        $this->handleRequest($command->className, $request);
    }

    /**
     * @param string $commandName
     * @return void
     * @throws Exception
     */
    private function checkForDuplicate(string $commandName): void
    {
        array_walk(
            $this->commands, function (CommandDto $commandDto) use ($commandName) {
            if ($commandDto->commandName === $commandName) {
                throw new Exception('duplicate command! '); // todo : change exception
            }
        });
    }

    /**
     * @throws CommandNotFoundException
     */
    private function findRelatedCommand(string $command): CommandDto
    {
        return [...array_filter($this->commands, function (CommandDto $dto) use ($command) {
            if ($dto->commandName === $command) {
                return $dto;
            }
        })][0] ?? throw new CommandNotFoundException();
    }

    /**
     * @throws ValidationException
     */
    private function validateRequest(?string $validator, Request $request): void
    {
        if ($validator !== null) {
            $validator = new $validator();
            $request->setValidator($validator);
        }
        $request->validate();
    }

    /**
     * @param string $className
     * @param Request $request
     * @return void
     */
    private function handleRequest(string $className, Request $request): void
    {
        $commandClass = new $className();
        assert($commandClass instanceof Command);
        $commandClass->handle($request);
    }
}