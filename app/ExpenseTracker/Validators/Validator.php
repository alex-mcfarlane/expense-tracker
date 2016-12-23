<?php
namespace App\ExpenseTracker\Validators;

use Validator as V;

abstract class Validator {

    protected $errors;
    
    public function isValid(array $attributes)
    {
        $v = V::make($attributes, static::$rules);
        
        if($v->fails()) {
            $this->errors = $v->messages();
            throw new \App\ExpenseTracker\Exceptions\ValidationException('Invalid user input', $this->errors);
            return false;
        }
        
        return true;
    }
    
    public function getErrors()
    {
        return $this->errors;
    }
}
