<?php

namespace App\ExpenseTracker\Exceptions;

use Exception;

class BillException extends BaseException
{
	public function __construct($errors)
	{
		parent::__construct("Bill exception", $errors);
	}
}
