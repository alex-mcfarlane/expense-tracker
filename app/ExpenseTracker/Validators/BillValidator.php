<?php

namespace App\ExpenseTracker\Validators;

/**
 * BillValidator Class
 * Validation rules for creating/updating a bill 
 * 
 * @author Alex McFarlane
 */
class BillValidator extends Validator
{
    //validation rules 
    protected static $rules = [
        'name' => 'required|max:255'
    ];
}
