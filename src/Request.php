<?php

namespace Src;

use Src\Exception\ValidationException;
use Src\Validate\Validable;

/**
 * @property $titles
 * @property $authors
 * @property $perPage
 */
class Request
{
    public string $task;
    private ?Validable $validable = null;

    /**
     * @param string $filePath
     */
    public function __construct(
        string $filePath
    )
    {
        $jsonContent = file_get_contents($filePath);
        $jsonData = json_decode($jsonContent, true);
        $this->task = $jsonData['command_name'];
        $this->setDynamicParameters($jsonData['parameters']);
    }

    /**
     * @param array $parameters
     * @return void
     */
    private function setDynamicParameters(array $parameters): void
    {
        foreach ($parameters as $parameter) {
            $this->$parameter = $parameters[$parameter];
        }
    }

    /**
     * @throws ValidationException
     */
    public function validate(): void
    {
        $this->validable?->validate($this);
    }

    /**
     * @param Validable $validator
     * @return void
     */
    public function setValidator(Validable $validator): void
    {
        $this->validable = $validator;
    }
}