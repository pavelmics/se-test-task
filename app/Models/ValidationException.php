<?php

namespace Models;

/**
 * Class ValidationException
 * Thrown when model is not valid
 *
 * @package Models
 */
class ValidationException extends \Exception
{
    protected $_errors = [];

    /**
     * @constructor
     * @param string $errors - validation errors
     * @param string $message
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct($errors
        , $message = "model validation failed"
        , $code = 0
        , \Exception $previous = null)
    {
        $this->_errors = $errors;

        parent::__construct($message, $code, $previous);
    }

    /**
     * Returns validation error
     * @return array
     */
    public function getErrors()
    {
        $errors = [];
        foreach ($this->_errors as $v) {
            $key = $v->getPropertyPath();
            $key = str_replace(['[', ']'], '', $key);
            $errors[$key] = $v->getMessage();
        }
        return $errors;
    }
} 