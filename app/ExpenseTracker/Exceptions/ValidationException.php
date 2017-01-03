<?php

namespace App\ExpenseTracker\Exceptions;

use Exception;

class ValidationException extends BaseException
{
	public function __construct($message, $errors)
	{
		parent::__construct($message, $errors);
	}
}
