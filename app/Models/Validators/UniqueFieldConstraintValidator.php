<?php
namespace Models\Validators;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Illuminate\Database\Capsule\Manager as DB;


class UniqueFieldConstraintValidator extends ConstraintValidator
{

    /**
     * @inheritdoc
     */
    public function validate($value, Constraint $constraint)
    {
        $model = $constraint->getModel();
        $table = $model->getTable();
        $fields = $constraint->getFields();

        $q = sprintf('SELECT id FROM `%s` WHERE '
            , $table
        );

        $fieldsCodnditions = [];
        foreach ($fields as $f) {
            $fieldsCodnditions[] = $f . '=' . "'"
                . addslashes($model->$f) . "'";
        }

        $q .= implode(' AND ', $fieldsCodnditions);
        $q .= ';';

        $ids = DB::select($q);

        if (0 !== count($ids)) {
            $this->context->addViolation($constraint->message, [
                '%field%' => implode(', ', $constraint->getFields()),
            ]);
        }
    }
} 