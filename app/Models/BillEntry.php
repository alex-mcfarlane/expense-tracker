<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\ExpenseTracker\Exceptions\ValidationException;
use App\ExpenseTracker\Exceptions\EntryException;
use Auth;

class BillEntry extends Model
{
    protected $fillable = ['due_date', 'amount', 'paid'];
    protected $appends = array('balance');

    public static function fromForm($bill, array $attributes)
    {
        $entry = new static;
        $entry->closed = false;
        $entry->fill($attributes);
        
        if($entry->canEdit($bill)) {
            $entry->isValid();
            return $entry;
        }
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

    public function edit($attributes)
    {
        if($this->canEdit())
        {
            $this->fill($attributes);
            $this->isValid();
        }
    }

    public function pay($payment)
    {
        if($this->canEdit()) {
            if($this->paid + $payment > $this->amount) {
                throw new ValidationException('Invalid model', ['Cumulative amount paid cannot be greater than the 
                    balance owing']);
            }

            $this->paid += $payment;

            if($this->isPaid()) {
                $this->markAsClosed();
            }
        }
    }

    public function payFull()
    {
        if($this->canEdit()) {
            $this->pay($this->balance);
        }
    }

    private function isValid()
    {
        $errors = [];

        if($this->paid > $this->amount) {
            $errors[] = "Amount paid cannot be greater than total bill amount.";
        }
        
        if(count($errors) > 0) {
            throw new ValidationException('Invalid model', $errors);
        }
        return true;
    }

    private function canEdit($bill = null)
    {
        //check if user is authorized for this bill
        $bill ? $userId = $bill->user_id : $userId = $this->bill->user_id;
        // TODO: Probably shouldn't use the Auth facade within the model. Refactor later
        if($userId != \Auth::id()) {
            throw new \App\ExpenseTracker\Exceptions\AuthorizationException('Not authorized to access this bill');
        }
        //is the entry closed
        if($this->closed) {
            throw new EntryException(
                ['This entry has been closed as the balance has been paid off.']
            );
        }

        return true;
    }
    
    private function isPaid()
    {
        return $this->paid == $this->amount;
    }
    
    private function markAsClosed()
    {
        $this->closed = true;
    }
}
