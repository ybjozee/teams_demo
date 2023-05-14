<?php

namespace App\Validation;

use App\RequestDTO\BaseDTO;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DTOValidator {

    public function __construct(private readonly ValidatorInterface $validator) { }

    public function validate(BaseDTO $dto)
    : array {

        $errors = $this->validator->validate($dto);

        return $this->formatErrors($errors);
    }

    private function formatErrors(ConstraintViolationListInterface $errors)
    : array {

        $formattedErrors = [];
        /**@var ConstraintViolationInterface $error */
        foreach ($errors as $error) {
            $propertyPath = $error->getPropertyPath();
            $errorValue = $this->getErrorValues($error);
            if (preg_match_all('/[[0-9]*[a-zA-Z]*]/', $propertyPath, $matches)) {
                [$arrayName, $index, $keyName] = $this->getKeys($propertyPath, $matches[0]);
                $formattedErrors[$arrayName][$index][$keyName] = $errorValue;
            } else {
                $formattedErrors[$propertyPath] = $errorValue;
            }
        }

        return $formattedErrors;
    }

    private function getErrorValues(ConstraintViolationInterface $error)
    : array {

        return [
            'error' => $error->getMessage(),
            'value' => $error->getInvalidValue(),
        ];
    }

    private function getKeys(string $fullPath, array $matches)
    : array {

        $parent = explode('[', $fullPath)[0];

        return [$parent, $this->cleanKey($matches[0]), $this->cleanKey($matches[1])];
    }

    private function cleanKey($string)
    : string {

        return substr($string, 1, strlen($string) - 2);
    }
}