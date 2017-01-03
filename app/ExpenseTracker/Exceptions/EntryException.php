<?php

namespace App\ExpenseTracker\Exceptions;

use Exception;

class EntryException extends BaseException
{
	public function __construct($errors)
	{
		parent::__construct("Bill entry exception", $errors);
	}
}
