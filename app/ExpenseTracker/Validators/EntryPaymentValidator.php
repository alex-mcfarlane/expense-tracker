<?php
namespace App\ExpenseTracker\Validators;

class EntryPaymentValidator extends Validator
{
	protected static $rules = [
        'payment' => 'required|numeric|min:0.01',
	];
}