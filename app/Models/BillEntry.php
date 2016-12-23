<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\ExpenseTracker\Exceptions\ValidationException;
use Auth;

class BillEntry extends Model
{
    protected $fillable = ['due_date', 'amount', 'paid'];
    protected $appends = array('balance');

    public static function fromForm(array $attributes)
    {
        $entry = new static;
        
        $entry->fill($attributes);
    }
    
    public function bill()
    {
    	return $this->belongsTo('App\Models\Bill');
    }

    public function scopeForBill($query, $billId)
    {
    	$query->where('bill_id', $bill);
    }

    public function getBalanceAttribute()
    {
    	return $this->calcBalance();
    }
    
    public function calcBalance()
    {
		$balance = $this->amount - $this->paid;
		return $balance;
    }

    public function pay($amount)
    {
    	if(! $this->validatePayment($amount)) {
    		return false;
    	}

    	$this->paid += $amount;
    	return true;
    }

    public function payFull()
    {
        $this->pay($this->balance);
    }

    public function isValid()
    {
        $errors = [];
        
        if($this->paid > $this->amount) {
            $errors[] = "Amount paid cannot be greater than total bill amount";
        }
        else if($this->amount <= $this->balance) {
            $errors[] = "Error message WIP";
        }
        
        if($errors->count() > 0) {
            throw new ValidationException('Invalid model', $errors);   
        }
        return true;
    }
}
