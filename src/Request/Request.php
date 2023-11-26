<?php

namespace Src\Request;

use Src\Dto\RuleParametersDto;
use Src\Exception\ValidationException;
use Src\Request\Rule\RequiredRule;
use Src\Request\Validate\Validable;


#[\AllowDynamicProperties]
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
        foreach ($parameters as $parameter => $value) {
            $this->$parameter = $value;
        }
    }

    /**
     * @throws ValidationException
     */
    public function validate(): void
    {
        if (!is_null($this->validable)) {
            $allRules = $this->validable?->getRules();
            foreach ($allRules as $parameter => $parameterRules) {
                if ($this->checkIfParameterIsPassed($parameter, $parameterRules)) {
                    foreach ($parameterRules as $rule) {
                        $rule = new $rule();
                        if (!($rule->validate(RuleParametersDto::fromData($this->$parameter)))) {
                            throw new ValidationException($rule->getFailureMessage());
                        }
                    }
                }
            }
        }
    }

    /**
     * @param Validable $validator
     * @return void
     */
    public function setValidator(Validable $validator): void
    {
        $this->validable = $validator;
    }

    /**
     * @throws ValidationException
     */
    private function checkIfParameterIsPassed(int|string $parameter, array $parameterRules): bool
    {
        if (isset($this->$parameter)) {
            return true;
        }
        if (in_array(RequiredRule::class, $parameterRules)) {
            throw new ValidationException("parameter {$parameter} is not passed");
        }
        return false;
    }
}