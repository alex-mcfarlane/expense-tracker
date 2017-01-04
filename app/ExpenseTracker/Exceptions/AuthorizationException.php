<?php

namespace App\ExpenseTracker\Exceptions;

/**
 * AuthorizationException class to handle all exceptions for unauthorized actions
 *
 */
class AuthorizationException extends BaseException {
    public function __construct($message)
    {
        parent::__construct($message, [$message]);
    }
}
