<?php

namespace App\Validation\Constraint;

use App\Validation\ConstraintValidator\NotEmptyConstraintValidator;
use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute]
class NotEmpty extends Constraint {

    public string $message = 'Value cannot be empty';

    public function __construct(?string $message = null) {

        parent::__construct();
        $this->message = $message ?? $this->message;
    }

    public function validatedBy()
    : string {

        return NotEmptyConstraintValidator::class;
    }
}