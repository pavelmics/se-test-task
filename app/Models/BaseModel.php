<?php
namespace Models;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

abstract class BaseModel extends Model
{
    /**
     * Validates the model
     * @return bool
     * @throws ValidationException
     */
    public final function validate()
    {
        $app = getDI();
        $data = $this->getAttributes();
        $rules = $this->rules();

        if ($rules instanceof Assert\Collection) {
            $errors = $app['validator']->validateValue($data, $rules);
            if (count($errors) > 0) {
                throw new ValidationException($errors);
            }
        }

        return true;
    }

    /**
     * Returns validation rules for the model
     * @return bool|Assert\Collection
     */
    protected function rules()
    {
        return false;
    }
}