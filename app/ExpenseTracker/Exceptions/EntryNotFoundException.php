<?php
namespace App\ExpenseTracker\Exceptions;

class EntryNotFoundException extends BaseException
{
	public function __construct($error)
	{
		parent::__construct("Bill entry not found", [$error]);
	}
}
