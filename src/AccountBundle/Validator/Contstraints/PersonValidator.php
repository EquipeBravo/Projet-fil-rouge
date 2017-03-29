<?php
namespace AccountBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PersonValidator extends ConstraintValidator
{
    public function validate($person, Constraint $constraint)
    {
        /*
        //add password validator ... TODO
        $password = $person->getPassword();
        if (!$password) {
            $this->context->buildViolation('Doit être active')
                ->atPath('category')
                ->addViolation();
        }*/
    }
}