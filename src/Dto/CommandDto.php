<?php

namespace Src\Dto;

use Src\Enum\CommandName;


class CommandDto
{
    /**
     * @param string $commandName
     * @param string $className
     * @param string|null $validator
     */
    public function __construct(
        public string $commandName,
        public string      $className,
        public ?string     $validator
    )
    {
    }

    /**
     * @param string $commandName
     * @param string $className
     * @param string|null $validator
     * @return CommandDto
     */
    public static function fromData(
        string $commandName,
        string      $className,
        ?string     $validator = null
    ): CommandDto
    {
        return new self(
            $commandName, $className, $validator
        );
    }
}