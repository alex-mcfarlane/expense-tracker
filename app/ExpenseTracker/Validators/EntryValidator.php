<?php
namespace App\ExpenseTracker\Validators;

class EntryValidator
{
	protected static $rules = [
		'due_date' => 'date',
        'amount' => 'required|numeric|min:0',
        'paid' => 'numeric|min:0',
	];
}