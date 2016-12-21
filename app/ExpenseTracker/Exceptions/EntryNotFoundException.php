<?php
namespace App\ExpenseTracker\Exceptions;

use Exception;

class EntryNotFoundException extends Exception
{
	protected $errors;

	public function __construct($message, $errors, $code = 0, Exception $previous = null)
	{
		$this->errors =  $errors;
		parent::__construct($message, $code, $previous);
	}

	public function getErrors()
	{
		return $this->errors;
	}
}
