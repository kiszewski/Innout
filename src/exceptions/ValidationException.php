<?php

class ValidationException extends AppException {
    private $errors = [];

    function __construct($errors = [], $message = "Erros de validação",
        $code = 0, $previous = null) {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }

    function getErrors() {
        return $this->errors;
    }

    function get($att) {
        return $this->errors[$att];
    }
}