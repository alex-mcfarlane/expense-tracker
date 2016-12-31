<?php
namespace App\ExpenseTracker\Validators;

class EntryValidator extends Validator
{
	protected static $rules = [
		'due_date' => 'date',
        'amount' => 'required|numeric|min:0.01',
        'paid' => 'numeric|min:0',
	];
}