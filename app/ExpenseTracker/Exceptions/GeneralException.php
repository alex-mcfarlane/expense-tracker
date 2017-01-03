<?php

namespace App\ExpenseTracker\Exceptions;

/**
 * GeneralException is an exception class for simple, single errors
 * 
 */
class GeneralException extends BaseException{
    public function __construct($error)
    {
        parent::__construct('Exception message with one error', [$error]);
    }
}
