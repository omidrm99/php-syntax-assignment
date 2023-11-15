<?php

namespace src;

class Command
{
    public string $task;

    public function __construct(
        string $filePath
    )
    {
        $jsonContent = file_get_contents($filePath);
        $jsonData = json_decode($jsonContent, true);
        $this->task = $jsonData['command_name'];
        $this->setDynamicParameters($jsonData['parameters']);
    }

    private function setDynamicParameters(array $parameters): void
    {
        foreach ($parameters as $parameter) {
            $this->$parameter = $parameters[$parameter];
        }
    }

}