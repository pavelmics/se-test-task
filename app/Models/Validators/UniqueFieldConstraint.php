<?php

namespace Models\Validators;

use Models\BaseModel;
use Symfony\Component\Validator\Constraint;

/**
 * Checks is there same row at the target table
 *
 * Class UniqueFieldConstraint
 * @package Models\Validators
 */
class UniqueFieldConstraint extends Constraint
{
    public $message = 'This %field% is already in use';

    /**
     * @var
     */
    protected $_model;

    /**
     * @var array
     */
    protected $_fields;

    /**
     * @inheritdoc
     */
    public function __construct(BaseModel $model, $fields, $options = null)
    {
        $this->_model = $model;
        $this->_fields = $fields;
        parent::__construct($options);
    }

    /**
     * @inheritdoc
     */
    public function validatedBy()
    {
        return get_class($this).'Validator';
    }

    /**
     * Return fields for checking
     * @return array
     */
    public function getFields()
    {
        return $this->_fields;
    }

    /**
     * Returns target table
     * @return mixed|null|string
     */
    public function getModel()
    {
        return $this->_model;
    }
} 