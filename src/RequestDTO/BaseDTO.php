<?php

namespace App\RequestDTO;

abstract class BaseDTO {

    protected array $requestBody;

    protected function get(string $parameterName)
    : mixed {

        if (isset($this->requestBody[$parameterName])) {
            $parameter = $this->requestBody[$parameterName];
            if ($parameter === '') {
                return null;
            }

            return $parameter;
        }

        return null;
    }
}