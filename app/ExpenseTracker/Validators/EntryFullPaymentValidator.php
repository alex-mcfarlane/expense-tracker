<?php
namespace App\ExpenseTracker\Validators;

class EntryFullPaymentValidator extends Validator
{
	protected static $rules = [
        'action' => 'required',
	];
}