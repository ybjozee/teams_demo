<?php

namespace App\Validation\ConstraintValidator;

use App\Validation\Constraint\NotEmpty;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class NotEmptyConstraintValidator extends ConstraintValidator {

    /**
     * @inheritDoc
     */
    public function validate(mixed $value, Constraint $constraint) {

        if (!$constraint instanceof NotEmpty) {
            throw new UnexpectedTypeException($constraint, NotEmpty::class);
        }

        if (is_null($value)) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        if (empty(trim($value))) {
            $this->context
                ->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}